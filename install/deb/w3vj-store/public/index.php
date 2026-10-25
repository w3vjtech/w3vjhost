<?php
declare(strict_types=1);

namespace W3vj\Store;

require __DIR__ . "/_bootstrap.php";

$plans = (new Plans(db()))->active();
$site = config()->get("site_name", "W3VJHOST");

Layout::header("", "$site — fast, secure web hosting with a modern control panel.");
?>
<section class="bg-white">
	<div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 md:grid-cols-2 md:items-center md:py-24">
		<div>
			<h1 class="text-4xl font-bold tracking-tight text-slate-900 md:text-5xl">Web hosting that just works</h1>
			<p class="mt-4 text-lg leading-8 text-slate-600">
				Host websites, email and databases on fast servers, managed from one simple control panel.
				Free SSL, daily backups and PHP, Node.js and Python apps included.
			</p>
			<div class="mt-8 flex flex-wrap gap-3">
				<a href="#pricing" class="rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">See plans</a>
				<a href="<?= h(config()->get("panel_url", "")) ?>" class="rounded-lg border border-slate-300 bg-white px-5 py-3 font-semibold text-slate-700 hover:bg-slate-50">Customer login</a>
			</div>
		</div>
		<ul class="grid gap-4 sm:grid-cols-2">
			<?php foreach ([
				["Websites & apps", "PHP, Node.js and Python apps with one-click installers."],
				["Email", "Professional mailboxes on your own domain, with spam protection."],
				["Databases", "MariaDB, PostgreSQL, MongoDB and Redis."],
				["Security", "Free SSL certificates, firewall and automatic backups."],
			] as [$title, $text]) { ?>
				<li class="rounded-xl border border-slate-200 bg-slate-50 p-5">
					<h2 class="font-semibold text-slate-900"><?= h($title) ?></h2>
					<p class="mt-1 text-sm leading-6 text-slate-600"><?= h($text) ?></p>
				</li>
			<?php } ?>
		</ul>
	</div>
</section>

<section id="pricing" class="mx-auto max-w-6xl scroll-mt-4 px-4 py-16">
	<h2 class="text-center text-3xl font-bold text-slate-900">Plans &amp; pricing</h2>
	<p class="mt-2 text-center text-slate-600">Prices include all features listed. Cancel any time.</p>
	<?php if (!$plans) { ?>
		<p class="mt-10 rounded-lg border border-amber-200 bg-amber-50 p-4 text-center text-amber-800">Plans are coming soon.</p>
	<?php } else { ?>
		<div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
			<?php foreach ($plans as $plan) { ?>
				<div class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
					<h3 class="text-lg font-semibold text-slate-900"><?= h($plan["title"]) ?></h3>
					<p class="mt-4">
						<span class="text-4xl font-bold text-slate-900"><?= h(money((int) $plan["price_paise"])) ?></span>
						<span class="text-slate-500">/ <?= h(Plans::periodLabel($plan["period"])) ?></span>
					</p>
					<ul class="mt-6 flex-1 space-y-2 text-sm">
						<?php foreach (Plans::features($plan) as $feature) { ?>
							<li class="flex items-start gap-2">
								<svg class="mt-0.5 size-4 shrink-0 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
								<?= h($feature) ?>
							</li>
						<?php } ?>
					</ul>
					<a href="/checkout.php?plan=<?= (int) $plan["id"] ?>" class="mt-6 rounded-lg bg-blue-600 px-4 py-3 text-center font-semibold text-white hover:bg-blue-700">Buy <?= h($plan["title"]) ?></a>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</section>

<section class="mx-auto max-w-3xl px-4">
	<h2 class="text-2xl font-bold text-slate-900">Questions</h2>
	<dl class="mt-6 divide-y divide-slate-200 rounded-xl border border-slate-200 bg-white">
		<?php foreach ([
			["How fast is my account ready?", "Right after payment. We email your control panel login within a minute."],
			["How does billing work?", "Plans renew automatically every month or year through Razorpay. You can cancel any time."],
			["Which payment methods do you accept?", "Cards, UPI, net banking and wallets supported by Razorpay."],
			["What happens if a payment fails?", "Razorpay retries automatically. If renewal stops, the account is suspended until payment succeeds."],
		] as [$q, $a]) { ?>
			<div class="p-5">
				<dt class="font-semibold text-slate-900"><?= h($q) ?></dt>
				<dd class="mt-1 text-slate-600"><?= h($a) ?></dd>
			</div>
		<?php } ?>
	</dl>
</section>
<?php
Layout::footer();
