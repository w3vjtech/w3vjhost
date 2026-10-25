<?php
// Checkout: validate the form, then create the order and its Razorpay subscription.

declare(strict_types=1);

namespace W3vj\Store;

final class Checkout {
	// Orders one IP may start per hour (each creates a Razorpay subscription)
	private const MAX_ORDERS_PER_HOUR = 5;

	public function __construct(private \PDO $db, private Razorpay $rzp, private HestiaApi $api) {}

	/** @return array<string, string> field => error message */
	public function validate(array $plan, string $email, string $name, string $username): array {
		$errors = array_filter([
			"email" => Validate::email($email),
			"name" => Validate::name($name),
			"username" => Validate::username($username),
		]);
		if (!isset($errors["username"])) {
			if ($this->usernameHeld($username, $email) || $this->api->userExists($username)) {
				$errors["username"] = "This username is already taken, please choose another one.";
			}
		}
		$stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE ip = ? AND created_at > NOW() - INTERVAL 1 HOUR");
		$stmt->execute([client_ip()]);
		if ((int) $stmt->fetchColumn() >= self::MAX_ORDERS_PER_HOUR) {
			$errors["form"] = "Too many orders from your network. Please try again in an hour.";
		}
		return $errors;
	}

	/** @return array order row incl. rzp_subscription_id */
	public function start(array $plan, string $email, string $name, string $username): array {
		$token = bin2hex(random_bytes(16));
		$this->db
			->prepare("INSERT INTO orders (token, plan_id, email, name, username, ip) VALUES (?, ?, ?, ?, ?, ?)")
			->execute([$token, $plan["id"], $email, $name, $username, client_ip()]);
		$orderId = (int) $this->db->lastInsertId();

		// Renew for up to 10 years; customers cancel any time from Razorpay's emails
		$count = $plan["period"] === "yearly" ? 10 : 120;
		try {
			$subscription = $this->rzp->createSubscription($plan["rzp_plan_id"], $count, [
				"order_token" => $token,
				"username" => $username,
			]);
			$subscriptionId = (string) ($subscription["id"] ?? "");
			if (!Razorpay::isId($subscriptionId, "sub")) {
				throw new RazorpayException("Razorpay returned no subscription id");
			}
		} catch (\Throwable $e) {
			// Don't leave an order that holds the username without a way to pay for it
			$this->db
				->prepare("UPDATE orders SET status = 'expired', last_error = ? WHERE id = ?")
				->execute([substr($e->getMessage(), 0, 255), $orderId]);
			throw $e;
		}
		$this->db->prepare("UPDATE orders SET rzp_subscription_id = ? WHERE id = ?")->execute([$subscriptionId, $orderId]);

		return ["id" => $orderId, "token" => $token, "rzp_subscription_id" => $subscriptionId];
	}

	public function byToken(string $token): ?array {
		if (!preg_match('/^[0-9a-f]{32}$/', $token)) {
			return null;
		}
		$stmt = $this->db->prepare(
			"SELECT o.*, p.title, p.price_paise, p.period, p.rzp_plan_id FROM orders o JOIN plans p ON p.id = o.plan_id WHERE o.token = ?",
		);
		$stmt->execute([$token]);
		return $stmt->fetch() ?: null;
	}

	// Another customer is paying for this name right now (unpaid orders expire after 24 h).
	// The same email may retry its own unpaid checkout.
	private function usernameHeld(string $username, string $email): bool {
		$stmt = $this->db->prepare(
			"SELECT COUNT(*) FROM orders WHERE username = ? AND (
				status IN ('failed', 'provisioned', 'suspended')
				OR (status = 'created' AND created_at > NOW() - INTERVAL 24 HOUR AND email <> ?)
			)",
		);
		$stmt->execute([$username, $email]);
		return (int) $stmt->fetchColumn() > 0;
	}
}
