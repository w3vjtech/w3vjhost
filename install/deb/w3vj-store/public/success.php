<?php
declare(strict_types=1);

namespace W3vj\Store;

require __DIR__ . "/_bootstrap.php";

header("Cache-Control: no-store");
$order = (new Checkout(db(), razorpay(), hestia()))->byToken((string) ($_GET["t"] ?? ""));
if (!$order) {
	header("Location: /", true, 303);
	exit();
}

$ready = in_array($order["status"], ["provisioned", "suspended"], true);
Layout::header("Thank you");
?>
<section class="mx-auto max-w-2xl px-4 py-16 text-center">
	<div class="mx-auto flex size-14 items-center justify-center rounded-full <?= $ready ? "bg-green-100 text-green-700" : "bg-amber-100 text-amber-700" ?>">
		<svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
			<?= $ready ? '<path d="M20 6 9 17l-5-5"/>' : '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>' ?>
		</svg>
	</div>
	<?php if ($ready) { ?>
		<h1 class="mt-6 text-3xl font-bold text-slate-900">Your account is ready</h1>
		<p class="mt-3 text-slate-600">
			We've emailed your login details to <strong><?= h($order["email"]) ?></strong>.
			Your username is <strong><?= h($order["hestia_user"]) ?></strong>.
		</p>
		<a href="<?= h(config()->get("panel_url", "")) ?>" class="mt-8 inline-block rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">Go to the control panel</a>
	<?php } elseif (in_array($order["status"], ["expired", "cancelled"], true)) { ?>
		<h1 class="mt-6 text-3xl font-bold text-slate-900">This order is no longer active</h1>
		<p class="mt-3 text-slate-600">No account was created for it. You can <a href="/#pricing" class="text-blue-700 underline">start a new order</a>.</p>
	<?php } else { ?>
		<h1 class="mt-6 text-3xl font-bold text-slate-900">Setting up your account</h1>
		<p class="mt-3 text-slate-600">
			We're confirming your payment and creating your <?= h($order["title"]) ?> account. You'll receive an email at
			<strong><?= h($order["email"]) ?></strong> within a few minutes. If you were charged, there's no need to pay again.
		</p>
		<p class="mt-6 text-sm text-slate-500">Questions? <a href="/contact.php" class="text-blue-700 underline">Contact us</a> and mention order <?= (int) $order["id"] ?>.</p>
	<?php } ?>
</section>
<?php
Layout::footer();
