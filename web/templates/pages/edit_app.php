<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/app/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true) { ?>
				<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" form="main-form">
					<i class="fas fa-floppy-disk icon-purple text-purple-700"></i><?= tohtml( _("Save")) ?>
				</button>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<form id="main-form" name="v_edit_app" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit Application")) ?></h1>
			<?php show_alert_message($_SESSION); ?>

			<div class="u-mb10 mb-[10px]">
				<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" id="v_domain" value="<?= tohtml($v_domain) ?>" disabled>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_template" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Runtime")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_template" id="v_template">
					<?php foreach ($v_templates as $template) { ?>
						<option value="<?= tohtml($template) ?>" <?= $template === $v_template ? "selected" : "" ?>><?= tohtml(app_template_label($template)) ?></option>
					<?php } ?>
				</select>
				<p class="hint text-sm leading-6 text-slate-500"><?= tohtml( _("Switching between Node.js and Python also needs a matching entry.")) ?></p>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_entry" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Entry")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_entry" id="v_entry" value="<?= tohtml($v_entry) ?>" maxlength="128" required>
			</div>
			<div class="form-check u-mb20 flex items-center gap-2 mb-[20px]">
				<input class="form-check-input accent-blue-600" type="checkbox" name="v_deps" id="v_deps" value="yes">
				<label for="v_deps"><?= tohtml( _("Reinstall dependencies (npm ci / pip install -r requirements.txt)")) ?></label>
			</div>

			<h2 class="u-mb10 mb-[10px]"><?= tohtml( _("Details")) ?></h2>
			<ul class="values-list u-mb20 mb-[20px]">
				<li class="values-list-item flex flex-wrap gap-2 py-1">
					<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Status")) ?></span>
					<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml(_(ucfirst($app["STATUS"] ?? "stopped"))) ?> (<?= tohtml($app["STATE"] ?? "") ?>)</span>
				</li>
				<li class="values-list-item flex flex-wrap gap-2 py-1">
					<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Code folder")) ?></span>
					<span class="values-list-value min-w-0 wrap-anywhere"><code><?= tohtml($app["DIR"] ?? "") ?></code></span>
				</li>
				<li class="values-list-item flex flex-wrap gap-2 py-1">
					<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Log")) ?></span>
					<span class="values-list-value min-w-0 wrap-anywhere"><code><?= tohtml(dirname($app["DIR"] ?? "") . "/logs/app.log") ?></code></span>
				</li>
				<li class="values-list-item flex flex-wrap gap-2 py-1">
					<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Socket")) ?></span>
					<span class="values-list-value min-w-0 wrap-anywhere"><code><?= tohtml($app["SOCKET"] ?? "") ?></code></span>
				</li>
			</ul>
		</div>
	</form>

</div>
