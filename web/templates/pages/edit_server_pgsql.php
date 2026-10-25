<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/server/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" form="main-form">
				<i class="fas fa-floppy-disk icon-purple text-purple-700"></i><?= tohtml( _("Save")) ?>
			</button>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<form id="main-form" name="v_configure_server" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Configure Server")) ?>: <?= tohtml($v_service_name) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb20 mb-[20px]">
				<label for="v_options" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml($v_options_path) ?></label>
				<textarea class="form-control u-min-height300 u-allow-resize u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[300px] min-w-full resize font-mono whitespace-pre leading-tight" name="v_options" id="v_options"><?= tohtml($v_options) ?></textarea>
			</div>
			<div class="u-mb20 mb-[20px]">
				<label for="v_config" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml($v_config_path) ?></label>
				<textarea class="form-control u-min-height300 u-allow-resize u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[300px] min-w-full resize font-mono whitespace-pre leading-tight" name="v_config" id="v_config"><?= tohtml($v_config) ?></textarea>
			</div>
			<div class="form-check flex items-center gap-2">
				<input class="form-check-input accent-blue-600" type="checkbox" name="v_restart" id="v_restart" checked>
				<label for="v_restart">
					<?= tohtml( _("Restart")) ?>
				</label>
			</div>
		</div>

	</form>

</div>
