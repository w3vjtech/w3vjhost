<?php
// Called by assets/checkout.js after Razorpay Checkout succeeds.
// Verifies the payment server-side, then creates the account.

declare(strict_types=1);

namespace W3vj\Store;

require dirname(__DIR__) . "/_bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	json_response(405, ["error" => "Method not allowed"]);
}
Session::start();
if (!Session::checkCsrf($_POST["csrf"] ?? null)) {
	json_response(403, ["error" => "Your session expired. If money was taken, your account will be created automatically."]);
}

$token = (string) ($_POST["token"] ?? "");
$paymentId = (string) ($_POST["razorpay_payment_id"] ?? "");
$subscriptionId = (string) ($_POST["razorpay_subscription_id"] ?? "");
$signature = (string) ($_POST["razorpay_signature"] ?? "");

// Only the browser session that started this order may confirm it
if (empty($_SESSION["orders"][$token]) || !Razorpay::isId($paymentId, "pay") || !Razorpay::isId($subscriptionId, "sub")) {
	json_response(400, ["error" => "Invalid payment details."]);
}

$order = (new Checkout(db(), razorpay(), hestia()))->byToken($token);
if (!$order || $order["rzp_subscription_id"] !== $subscriptionId) {
	json_response(400, ["error" => "Invalid payment details."]);
}

$keySecret = (string) (config()->get("razorpay")["key_secret"] ?? "");
if (!Razorpay::verifyPaymentSignature($paymentId, $subscriptionId, $signature, $keySecret)) {
	error_log("w3vj-store confirm: bad signature for order {$order["id"]}");
	json_response(400, ["error" => "Payment could not be verified."]);
}

$success = "/success.php?t=" . $order["token"];
try {
	// Ask Razorpay directly: right plan, our order, and actually paid/authorised
	$subscription = razorpay()->fetchSubscription($subscriptionId);
	$okStatus = in_array($subscription["status"] ?? "", ["authenticated", "active"], true);
	$okPlan = ($subscription["plan_id"] ?? "") === $order["rzp_plan_id"];
	$okNotes = ($subscription["notes"]["order_token"] ?? "") === $order["token"];
	if (!$okStatus || !$okPlan || !$okNotes) {
		error_log("w3vj-store confirm: subscription $subscriptionId failed checks for order {$order["id"]}");
		json_response(400, ["error" => "Payment could not be verified."]);
	}
	provisioner()->provision($subscriptionId, $paymentId);
} catch (\Throwable $e) {
	// Paid but not provisioned yet: the webhook and the hourly retry will finish the job
	error_log("w3vj-store confirm: " . $e->getMessage());
}

json_response(200, ["redirect" => $success]);
