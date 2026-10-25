<?php
// Turns paid subscriptions into panel accounts and keeps account state in step with billing.
// Every method is idempotent: the Checkout callback and Razorpay webhooks can both arrive,
// in any order and more than once.

declare(strict_types=1);

namespace W3vj\Store;

final class Provisioner {
	private const MAX_ATTEMPTS = 5;

	public function __construct(
		private \PDO $db,
		private HestiaApi $api,
		private Mailer $mail,
		private Config $config,
	) {}

	/**
	 * Create the account for a paid subscription.
	 * @return string resulting order status, or "unknown" when no order matches
	 */
	public function provision(string $subscriptionId, ?string $paymentId = null): string {
		$this->db->beginTransaction();
		try {
			// Row lock: a concurrent confirm/webhook waits here and then sees "provisioned"
			$stmt = $this->db->prepare(
				"SELECT o.*, p.package, p.title FROM orders o JOIN plans p ON p.id = o.plan_id
				 WHERE o.rzp_subscription_id = ? FOR UPDATE",
			);
			$stmt->execute([$subscriptionId]);
			$order = $stmt->fetch();
			if (!$order) {
				$this->db->commit();
				return "unknown";
			}
			if (in_array($order["status"], ["provisioned", "suspended"], true)) {
				$this->db->commit();
				return $order["status"];
			}
			// "cancelled" stays cancelled; a late payment on an expired order is still honoured
			if ($order["status"] === "cancelled") {
				$this->db->commit();
				return "cancelled";
			}

			$password = Validate::newPassword();
			try {
				$user = $this->freeUsername($order["username"]);
				$this->api->addUser($user, $password, $order["email"], $order["package"], $order["name"]);
			} catch (\Throwable $e) {
				$this->db
					->prepare("UPDATE orders SET status = 'failed', attempts = attempts + 1, last_error = ?,
					           rzp_payment_id = COALESCE(?, rzp_payment_id) WHERE id = ?")
					->execute([substr($e->getMessage(), 0, 255), $paymentId, $order["id"]]);
				$this->db->commit();
				if ((int) $order["attempts"] + 1 >= self::MAX_ATTEMPTS) {
					$this->mail->notifyAdmin(
						"Provisioning failed for order {$order["id"]}",
						"Subscription $subscriptionId paid, but the account could not be created after " .
							self::MAX_ATTEMPTS . " attempts.\nLast error: {$e->getMessage()}\n",
					);
				}
				return "failed";
			}

			$this->db
				->prepare("UPDATE orders SET status = 'provisioned', hestia_user = ?, attempts = attempts + 1,
				           last_error = NULL, rzp_payment_id = COALESCE(?, rzp_payment_id) WHERE id = ?")
				->execute([$user, $paymentId, $order["id"]]);
			$this->db->commit();
		} catch (\Throwable $e) {
			if ($this->db->inTransaction()) {
				$this->db->rollBack();
			}
			throw $e;
		}

		// Mail after commit: a mail failure must not undo a created account
		if (!$this->mail->sendCredentials($order["email"], $order["name"], $user, $password, $order["title"])) {
			$this->mail->notifyAdmin(
				"Welcome email failed for $user",
				"Account $user was created for {$order["email"]} but the welcome email could not be sent.\n" .
					"Reset the password in the panel and send it to the customer.\n",
			);
		}
		return "provisioned";
	}

	// Billing stopped (halted, cancelled, completed, paused)
	public function suspend(string $subscriptionId, bool $cancelled = false): string {
		$order = $this->order($subscriptionId);
		if (!$order) {
			return "unknown";
		}
		if ($order["status"] === "provisioned") {
			$this->api->suspendUser($order["hestia_user"]);
		}
		if ($order["hestia_user"] !== null) {
			$status = "suspended";
		} else {
			// Never provisioned: nothing to suspend
			$status = $cancelled ? "cancelled" : $order["status"];
		}
		$this->setStatus((int) $order["id"], $status);
		return $status;
	}

	// Billing resumed (charged, resumed, activated)
	public function unsuspend(string $subscriptionId): string {
		$order = $this->order($subscriptionId);
		if (!$order) {
			return "unknown";
		}
		if ($order["status"] === "suspended" && $order["hestia_user"] !== null) {
			$this->api->unsuspendUser($order["hestia_user"]);
			$this->setStatus((int) $order["id"], "provisioned");
			return "provisioned";
		}
		return $order["status"];
	}

	// Retry failed provisions (called by cli.php maintain)
	public function retryFailed(): int {
		$stmt = $this->db->prepare(
			"SELECT rzp_subscription_id FROM orders WHERE status = 'failed' AND attempts < ? AND rzp_subscription_id IS NOT NULL",
		);
		$stmt->execute([self::MAX_ATTEMPTS]);
		$done = 0;
		foreach ($stmt->fetchAll(\PDO::FETCH_COLUMN) as $subscriptionId) {
			if ($this->provision($subscriptionId) === "provisioned") {
				$done++;
			}
		}
		return $done;
	}

	// Wanted name, or the name plus digits if someone took it since checkout
	private function freeUsername(string $wanted): string {
		if (!$this->api->userExists($wanted)) {
			return $wanted;
		}
		for ($i = 0; $i < 10; $i++) {
			$candidate = substr($wanted, 0, 26) . random_int(100, 9999);
			if (!$this->api->userExists($candidate)) {
				return $candidate;
			}
		}
		throw new \RuntimeException("No free username found for $wanted");
	}

	private function order(string $subscriptionId): ?array {
		$stmt = $this->db->prepare("SELECT * FROM orders WHERE rzp_subscription_id = ?");
		$stmt->execute([$subscriptionId]);
		return $stmt->fetch() ?: null;
	}

	private function setStatus(int $orderId, string $status): void {
		$this->db->prepare("UPDATE orders SET status = ? WHERE id = ?")->execute([$status, $orderId]);
	}
}
