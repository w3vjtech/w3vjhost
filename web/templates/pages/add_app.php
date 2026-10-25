<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/app/">
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

	<form id="main-form" name="v_add_app" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add Application")) ?></h1>
			<?php show_alert_message($_SESSION); ?>

			<?php if (empty($v_domains)) { ?>
				<p class="u-mb20 mb-[20px]"><?= tohtml( _("All your web domains already run an application, or you have none yet.")) ?></p>
			<?php } elseif (empty($v_templates)) { ?>
				<p class="u-mb20 mb-[20px]"><?= tohtml( _("No Node.js or Python runtime is installed yet. Ask your administrator to enable one in Server Settings → Application Runtimes.")) ?></p>
			<?php } else { ?>
				<div class="u-mb10 mb-[10px]">
					<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_domain" id="v_domain">
						<?php foreach ($v_domains as $domain) { ?>
							<option value="<?= tohtml($domain) ?>" <?= $domain === $v_domain ? "selected" : "" ?>><?= tohtml($domain) ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_template" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Runtime")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_template" id="v_template">
						<?php foreach ($v_templates as $template) { ?>
							<option value="<?= tohtml($template) ?>" <?= $template === $v_template ? "selected" : "" ?>><?= tohtml(app_template_label($template)) ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_entry" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Entry")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_entry" id="v_entry" value="<?= tohtml($v_entry) ?>" placeholder="server.js" maxlength="128" required>
					<p class="hint text-sm leading-6 text-slate-500">
						<?= tohtml( _("Node.js: the start file inside the app folder, for example server.js or dist/main.js.")) ?><br>
						<?= tohtml( _("Python: module:application for gunicorn, for example wsgi:app or main:create_app().")) ?>
					</p>
				</div>
				<div class="alert alert-info u-mb10 mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-blue-200 bg-blue-50 text-blue-800 mb-[10px]" role="alert">
					<i class="fas fa-info"></i>
					<p>
						<?= tohtml( _("Upload your code to /home/USER/web/DOMAIN/app. The application listens on the socket given in the PORT environment variable (Node.js) or is started by gunicorn (Python). PHP is turned off for this domain; deleting the application turns it back on.")) ?>
					</p>
				</div>
			<?php } ?>
		</div>
	</form>

</div>
