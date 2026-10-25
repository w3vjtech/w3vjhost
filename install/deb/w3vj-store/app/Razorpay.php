<?php
// Minimal Razorpay REST client (plans, subscriptions) and signature checks.
// https://razorpay.com/docs/api/payments/subscriptions/

declare(strict_types=1);

namespace W3vj\Store;

final class Razorpay {
	private const API = "https://api.razorpay.com/v1/";

	public function __construct(private string $keyId, private string $keySecret) {}

	public function keyId(): string {
		return $this->keyId;
	}

	/** @param 'monthly'|'yearly' $period */
	public function createPlan(string $period, int $amountPaise, string $name, string $currency = "INR"): array {
		return $this->request("POST", "plans", [
			"period" => $period,
			"interval" => 1,
			"item" => ["name" => $name, "amount" => $amountPaise, "currency" => $currency],
		]);
	}

	public function createSubscription(string $planId, int $totalCount, array $notes): array {
		return $this->request("POST", "subscriptions", [
			"plan_id" => $planId,
			"total_count" => $totalCount,
			"customer_notify" => 1,
			"notes" => $notes,
		]);
	}

	public function fetchSubscription(string $subscriptionId): array {
		self::assertId($subscriptionId, "sub");
		return $this->request("GET", "subscriptions/" . $subscriptionId);
	}

	public function cancelSubscription(string $subscriptionId): array {
		self::assertId($subscriptionId, "sub");
		return $this->request("POST", "subscriptions/" . $subscriptionId . "/cancel", ["cancel_at_cycle_end" => 0]);
	}

	// Checkout handler signature for subscriptions: HMAC(payment_id|subscription_id, key_secret)
	public static function verifyPaymentSignature(
		string $paymentId,
		string $subscriptionId,
		string $signature,
		string $keySecret,
	): bool {
		if ($keySecret === "" || $signature === "") {
			return false;
		}
		$expected = hash_hmac("sha256", $paymentId . "|" . $subscriptionId, $keySecret);
		return hash_equals($expected, $signature);
	}

	// Webhook signature: HMAC(raw request body, webhook secret)
	public static function verifyWebhookSignature(string $body, string $signature, string $webhookSecret): bool {
		if ($webhookSecret === "" || $signature === "") {
			return false;
		}
		return hash_equals(hash_hmac("sha256", $body, $webhookSecret), $signature);
	}

	public static function isId(string $value, string $prefix): bool {
		return (bool) preg_match('/^' . $prefix . '_[A-Za-z0-9]{8,32}$/', $value);
	}

	private static function assertId(string $value, string $prefix): void {
		if (!self::isId($value, $prefix)) {
			throw new \InvalidArgumentException("Invalid Razorpay $prefix id");
		}
	}

	private function request(string $method, string $path, ?array $body = null): array {
		if ($this->keyId === "" || $this->keySecret === "") {
			throw new RazorpayException("Razorpay keys are not configured (run: v-w3vj-store set-keys)");
		}
		$ch = curl_init(self::API . $path);
		$options = [
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_USERPWD => $this->keyId . ":" . $this->keySecret,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
		];
		if ($body !== null) {
			$options[CURLOPT_POSTFIELDS] = json_encode($body, JSON_UNESCAPED_SLASHES);
		}
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);
		$status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		$error = curl_error($ch);
		curl_close($ch);

		if ($response === false) {
			throw new RazorpayException("Razorpay connection failed: $error");
		}
		$data = json_decode((string) $response, true);
		if ($status >= 400 || !is_array($data)) {
			$message = is_array($data) ? (string) ($data["error"]["description"] ?? "HTTP $status") : "HTTP $status";
			throw new RazorpayException("Razorpay: $message", $status);
		}
		return $data;
	}
}
