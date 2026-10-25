<?php
// Razorpay webhook (Dashboard > Settings > Webhooks): https://STORE_DOMAIN/api/webhook.php
// Active events: subscription.activated, .charged, .halted, .cancelled, .completed, .paused, .resumed

declare(strict_types=1);

namespace W3vj\Store;

require dirname(__DIR__) . "/_bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	json_response(405, ["error" => "Method not allowed"]);
}

$body = (string) file_get_contents("php://input");
$signature = (string) ($_SERVER["HTTP_X_RAZORPAY_SIGNATURE"] ?? "");
$secret = (string) (config()->get("razorpay")["webhook_secret"] ?? "");
if (!Razorpay::verifyWebhookSignature($body, $signature, $secret)) {
	json_response(400, ["error" => "Invalid signature"]);
}

$event = json_decode($body, true);
$type = (string) ($event["event"] ?? "");
$subscription = $event["payload"]["subscription"]["entity"] ?? [];
$subscriptionId = (string) ($subscription["id"] ?? "");
$paymentId = $event["payload"]["payment"]["entity"]["id"] ?? null;
$eventId = (string) ($_SERVER["HTTP_X_RAZORPAY_EVENT_ID"] ?? "");

if (!str_starts_with($type, "subscription.") || !Razorpay::isId($subscriptionId, "sub")) {
	// Not for us; acknowledge so Razorpay stops retrying
	json_response(200, ["ok" => true, "ignored" => $type]);
}

$db = db();
if ($eventId !== "") {
	$insert = $db->prepare("INSERT IGNORE INTO events (event_id, type) VALUES (?, ?)");
	$insert->execute([substr($eventId, 0, 64), substr($type, 0, 64)]);
	if ($insert->rowCount() === 0) {
		json_response(200, ["ok" => true, "duplicate" => true]);
	}
}

try {
	$provisioner = provisioner();
	$result = match ($type) {
		"subscription.activated", "subscription.charged" => (function () use ($provisioner, $subscriptionId, $paymentId) {
			$status = $provisioner->provision($subscriptionId, is_string($paymentId) ? $paymentId : null);
			// A renewal that succeeds after a halt brings the account back
			return $status === "suspended" ? $provisioner->unsuspend($subscriptionId) : $status;
		})(),
		"subscription.resumed" => $provisioner->unsuspend($subscriptionId),
		"subscription.halted", "subscription.paused", "subscription.completed" => $provisioner->suspend($subscriptionId),
		"subscription.cancelled" => $provisioner->suspend($subscriptionId, true),
		default => "ignored",
	};
} catch (\Throwable $e) {
	error_log("w3vj-store webhook $type $subscriptionId: " . $e->getMessage());
	// Forget the event so Razorpay's retry is processed again
	if ($eventId !== "") {
		$db->prepare("DELETE FROM events WHERE event_id = ?")->execute([substr($eventId, 0, 64)]);
	}
	json_response(500, ["error" => "Temporary failure"]);
}

json_response(200, ["ok" => true, "status" => $result]);
