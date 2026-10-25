<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/edit/web/?<?= tohtml(http_build_query(["domain" => $v_domain])) ?>">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<div class="form-container form-container-wide mx-auto w-full max-w-2xl py-6 max-w-5xl">
		<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Quick Install App")) ?></h1>
		<?php show_alert_message($_SESSION); ?>
		<div class="cards grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
			<!-- List available web apps -->
			<?php foreach ($v_web_apps as $webapp): ?>
				<div class="card <?= tohtml($webapp->isInstallable() ? "" : "disabled") ?> overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
					<div class="card-thumb flex h-40 items-center justify-center p-4 [&_img]:max-h-full [&_img]:max-w-full">
						<img src="/src/app/WebApp/Installers/<?= tohtml($webapp->name) ?>/<?= tohtml($webapp->thumbnail) ?>" alt="<?= tohtml($webapp->name) ?>">
					</div>
					<div class="card-content p-4 text-center text-slate-700">
						<p class="card-title font-semibold"><?= tohtml($webapp->name) ?></p>
						<p class="u-mb10 mb-[10px]"><?= tohtml( _("Version")) ?>: <?= tohtml($webapp->version) ?></p>
						<a class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" href="/add/webapp/?<?= tohtml(http_build_query(["app" => $webapp->name, "domain" => $v_domain])) ?>">
							<?= tohtml( _("Setup")) ?>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

</div>
