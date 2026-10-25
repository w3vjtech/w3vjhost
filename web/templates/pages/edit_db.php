<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/db/">
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

	<form id="main-form" name="v_edit_db" method="post" class="<?= tohtml($v_status) ?>">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit Database")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_database" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Database")) ?></label>
				<input type="text" class="form-control js-db-hint-database-name block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_database" id="v_database" value="<?= tohtml(trim($v_database, "'")) ?>" disabled>
				<small class="hint text-sm leading-6 text-slate-500"></small>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_dbuser" class="form-label u-side-by-side mb-1 block text-sm font-semibold text-slate-700 flex flex-wrap items-center gap-2">
					<?= tohtml( _("Username")) ?>
					<em><small>(<?= tohtml(sprintf(_("Maximum %s characters length, including prefix"), 32)) ?>)</small></em>
				</label>
				<input type="text" class="form-control js-db-hint-username block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_dbuser" id="v_dbuser" value="<?= tohtml(trim($v_dbuser, "'")) ?>">
				<small class="hint text-sm leading-6 text-slate-500"></small>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_password" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Password")) ?>
					<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-generate-password ml-[5px] border-0 bg-transparent p-0">
						<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
					</button>
				</label>
				<div class="u-pos-relative u-mb10 mb-[10px] relative">
					<input type="text" class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_password" id="v_password" value="<?= tohtml(trim($v_password, "'")) ?>">
					<div class="password-meter relative">
						<meter max="4" class="password-meter-input js-password-meter pr-10"></meter>
					</div>
				</div>
			</div>
			<?php require $_SERVER["HESTIA"] . "/web/templates/includes/password-requirements.php"; ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_type" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Type")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_type" id="v_type" value="<?= tohtml(trim($v_type, "'")) ?>" disabled>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_host" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Host")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_host" id="v_host" value="<?= tohtml(trim($v_host, "'")) ?>" disabled>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_charset" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Charset")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_charset" id="v_charset" value="<?= tohtml(trim($v_charset, "'")) ?>" disabled>
			</div>
		</div>

	</form>

</div>
