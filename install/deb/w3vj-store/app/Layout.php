<?php
// Page shell for the public store pages. Tailwind classes only (assets/store.min.css).

declare(strict_types=1);

namespace W3vj\Store;

final class Layout {
	public static function header(string $title, string $description = ""): void {
		$site = config()->get("site_name", "W3VJHOST");
		$css = "/assets/store.min.css?v=" . @filemtime(dirname(__DIR__, 2) . "/public_html/assets/store.min.css");
		header("X-Content-Type-Options: nosniff");
		header("Referrer-Policy: strict-origin-when-cross-origin");
		header("X-Frame-Options: DENY");
		?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= h($title === "" ? $site : "$title · $site") ?></title>
	<?php if ($description !== "") { ?><meta name="description" content="<?= h($description) ?>"><?php } ?>
	<link rel="icon" href="/assets/logo.svg" type="image/svg+xml">
	<link rel="stylesheet" href="<?= h($css) ?>">
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-700 antialiased">
	<header class="border-b border-slate-200 bg-white">
		<div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
			<a href="/" class="flex items-center gap-2 text-lg font-bold text-slate-900">
				<img src="/assets/logo.svg" alt="" class="size-8">
				<?= h($site) ?>
			</a>
			<nav class="flex items-center gap-1 text-sm font-medium sm:gap-4">
				<a href="/#pricing" class="rounded-md px-3 py-2 hover:bg-slate-100">Pricing</a>
				<a href="/contact.php" class="hidden rounded-md px-3 py-2 hover:bg-slate-100 sm:inline">Contact</a>
				<a href="<?= h(config()->get("panel_url", "")) ?>" class="rounded-lg border border-blue-600 px-3 py-2 text-blue-700 hover:bg-blue-50">Log in</a>
			</nav>
		</div>
	</header>
	<main>
<?php
	}

	public static function footer(): void {
		$site = config()->get("site_name", "W3VJHOST");
		?>
	</main>
	<footer class="mt-16 border-t border-slate-200 bg-white">
		<div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
			<p>© <?= date("Y") ?> <?= h(config()->get("business_name", $site)) ?></p>
			<nav class="flex flex-wrap gap-4">
				<a href="/terms.php" class="hover:text-slate-900">Terms</a>
				<a href="/privacy.php" class="hover:text-slate-900">Privacy</a>
				<a href="/refund.php" class="hover:text-slate-900">Refunds &amp; cancellation</a>
				<a href="/contact.php" class="hover:text-slate-900">Contact</a>
			</nav>
		</div>
	</footer>
</body>
</html>
<?php
	}

	// Simple page for policy/contact texts; $html is trusted template markup
	public static function textPage(string $title, string $html): void {
		self::header($title);
		?>
		<article class="mx-auto max-w-3xl px-4 py-12 [&_h2]:mt-8 [&_h2]:text-xl [&_h2]:font-semibold [&_h2]:text-slate-900 [&_p]:mt-3 [&_p]:leading-7 [&_ul]:mt-3 [&_ul]:list-disc [&_ul]:pl-6">
			<h1 class="text-3xl font-bold text-slate-900"><?= h($title) ?></h1>
			<p class="text-sm text-slate-500">Last updated: <?= h(config()->get("policies_updated", date("j F Y"))) ?></p>
			<?= $html ?>
		</article>
		<?php
		self::footer();
	}
}
