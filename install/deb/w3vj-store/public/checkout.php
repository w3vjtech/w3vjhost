<?php
declare(strict_types=1);

namespace W3vj\Store;

require __DIR__ . "/_bootstrap.php";

Session::start();
header("Cache-Control: no-store");

$plans = new Plans(db());
$plan = $plans->find((int) ($_GET["plan"] ?? $_POST["plan"] ?? 0));
if (!$plan) {
	header("Location: /#pricing", true, 303);
	exit();
}

$values = ["email" => "", "name" => "", "username" => ""];
$errors = [];
$order = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	foreach ($values as $key => $_) {
		$values[$key] = trim((string) ($_POST[$key] ?? ""));
	}
	$values["username"] = strtolower($values["username"]);
	$values["email"] = strtolower($values["email"]);

	if (!Session::checkCsrf($_POST["csrf"] ?? null)) {
		$errors["form"] = "Your session expired. Please submit the form again.";
	} elseif (!config()->razorpayReady()) {
		$errors["form"] = "Payments are not available right now. Please try again later.";
	} elseif (empty($_POST["terms"])) {
		$errors["terms"] = "Please accept the terms to continue.";
	} else {
		try {
			$checkout = new Checkout(db(), razorpay(), hestia());
			$errors = $checkout->validate($plan, $values["email"], $values["name"], $values["username"]);
			if (!$errors) {
				$order = $checkout->start($plan, $values["email"], $values["name"], $values["username"]);
				// Only this browser session may confirm this order
				$_SESSION["orders"][$order["token"]] = true;
			}
		} catch (\Throwable $e) {
			error_log("w3vj-store checkout: " . $e->getMessage());
			$errors["form"] = "We could not start the payment. Please try again in a few minutes.";
		}
	}
}

$site = config()->get("site_name", "W3VJHOST");
$price = money((int) $plan["price_paise"]) . " / " . Plans::periodLabel($plan["period"]);
$field = "block min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-600 focus:outline-2 focus:outline-blue-200";

Layout::header("Checkout");
?>
<section class="mx-auto grid max-w-5xl gap-8 px-4 py-12 md:grid-cols-[1fr_320px]">
	<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
		<?php if ($order) { ?>
			<h1 class="text-2xl font-bold text-slate-900">Complete your payment</h1>
			<p class="mt-2 text-slate-600">Razorpay's secure payment window opens now. If it doesn't, use the button below.</p>
			<p class="js-pay-status mt-4 hidden rounded-lg border border-amber-200 bg-amber-50 p-3 text-sm text-amber-800" role="status"></p>
			<button type="button" class="js-pay mt-6 w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white hover:bg-blue-700 disabled:opacity-50">Pay <?= h($price) ?></button>
			<script type="application/json" id="checkout-data"><?= json_encode([
				"key" => razorpay()->keyId(),
				"subscription_id" => $order["rzp_subscription_id"],
				"token" => $order["token"],
				"csrf" => Session::csrfToken(),
				"name" => $site,
				"description" => $plan["title"] . " — " . $price,
				"prefill" => ["email" => $values["email"], "name" => $values["name"]],
			], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
			<!-- Razorpay serves Checkout only from this unversioned URL, so no integrity hash is possible -->
			<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
			<script src="/assets/checkout.js?v=<?= (int) @filemtime(__DIR__ . "/assets/checkout.js") ?>"></script>
		<?php } else { ?>
			<h1 class="text-2xl font-bold text-slate-900">Create your account</h1>
			<p class="mt-2 text-slate-600">Your control panel login is emailed to you right after payment.</p>
			<?php if (isset($errors["form"])) { ?>
				<p class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800" role="alert"><?= h($errors["form"]) ?></p>
			<?php } ?>
			<form method="post" action="/checkout.php" class="mt-6 space-y-5" novalidate>
				<input type="hidden" name="csrf" value="<?= h(Session::csrfToken()) ?>">
				<input type="hidden" name="plan" value="<?= (int) $plan["id"] ?>">
				<?php foreach ([
					["email", "Email", "email", "email", "Your login details are sent here."],
					["name", "Full name", "text", "name", ""],
					["username", "Username", "text", "username", "2-30 lowercase letters, digits, dots, dashes or underscores. Used to log in."],
				] as [$key, $label, $type, $autocomplete, $hint]) { ?>
					<div>
						<label for="<?= $key ?>" class="mb-1 block text-sm font-semibold text-slate-800"><?= h($label) ?></label>
						<input id="<?= $key ?>" name="<?= $key ?>" type="<?= $type ?>" autocomplete="<?= $autocomplete ?>" required
							value="<?= h($values[$key]) ?>" class="<?= $field ?>"
							<?php if (isset($errors[$key])) { ?>aria-invalid="true" aria-describedby="<?= $key ?>-error"<?php } ?>>
						<?php if (isset($errors[$key])) { ?>
							<p id="<?= $key ?>-error" class="mt-1 text-sm text-red-700"><?= h($errors[$key]) ?></p>
						<?php } elseif ($hint !== "") { ?>
							<p class="mt-1 text-sm text-slate-500"><?= h($hint) ?></p>
						<?php } ?>
					</div>
				<?php } ?>
				<div>
					<label class="flex items-start gap-2 text-sm">
						<input type="checkbox" name="terms" value="1" class="mt-1 accent-blue-600" <?= !empty($_POST["terms"]) ? "checked" : "" ?>>
						<span>I agree to the <a href="/terms.php" class="text-blue-700 underline" target="_blank">terms</a> and the <a href="/refund.php" class="text-blue-700 underline" target="_blank">refund &amp; cancellation policy</a>, and authorise automatic renewal.</span>
					</label>
					<?php if (isset($errors["terms"])) { ?><p class="mt-1 text-sm text-red-700"><?= h($errors["terms"]) ?></p><?php } ?>
				</div>
				<button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white hover:bg-blue-700">Continue to payment</button>
			</form>
		<?php } ?>
	</div>
	<aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
		<h2 class="font-semibold text-slate-900">Your plan</h2>
		<p class="mt-2 text-lg font-semibold text-slate-900"><?= h($plan["title"]) ?></p>
		<p class="text-slate-600"><?= h($price) ?>, renews automatically</p>
		<ul class="mt-4 space-y-1 text-sm text-slate-600">
			<?php foreach (Plans::features($plan) as $feature) { ?><li>• <?= h($feature) ?></li><?php } ?>
		</ul>
		<a href="/#pricing" class="mt-4 inline-block text-sm text-blue-700 underline">Change plan</a>
	</aside>
</section>
<?php
Layout::footer();
