<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/backup/exclusions/">
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

	<form id="main-form" name="v_edit_backup_exclusions" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit Backup Exclusions")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_web" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Web Domains")) ?></label>
				<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_web" id="v_web" placeholder="<?= tohtml( _("Type domain name, one per line. To exclude all domains use *. To exclude specific dirs use following format: domain.tld:public_html/cache:public_html/tmp")) ?>"><?= tohtml(trim($v_web, "'")) ?></textarea>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_mail" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Mail Domains")) ?></label>
				<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_mail" id="v_mail" placeholder="<?= tohtml( _("Type domain name, one per line. To exclude all domains use *. To exclude specific accounts use following format: domain.tld:info:support:postmaster")) ?>"><?= tohtml(trim($v_mail, "'")) ?></textarea>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_db" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Databases")) ?></label>
				<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_db" id="v_db" placeholder="<?= tohtml( _("Type full database name, one per line. To exclude all databases use *")) ?>"><?= tohtml(trim($v_db, "'")) ?></textarea>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_userdir" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("User Directory")) ?></label>
				<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_userdir" id="v_userdir" placeholder="<?= tohtml( _("Type directory name, one per line. To exlude all dirs use *")) ?>"><?= tohtml(trim($v_userdir, "'")) ?></textarea>
			</div>
		</div>

	</form>

</div>
