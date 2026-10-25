<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a href="/edit/server/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" id="btn-back">
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

<!-- Begin form -->
<div class="container mx-auto w-full max-w-none px-4 md:px-6">
	<form
		x-data="{
			hide_docs: '<?= tohtml($v_hide_docs ?? "no") ?>',
		}"
		id="main-form"
		name="v_configure_server"
		method="post"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]">
				<?= tohtml( _("White Label Options")) ?>
			</h1>
			<?php show_alert_message($_SESSION); ?>

			<!-- Basic options section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-gear u-mr15 mr-[15px]"></i>
					<?= tohtml( _("General")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_app_name" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Application Name")) ?>
						</label>
						<input
							type="text"
							class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
							name="v_app_name"
							id="v_app_name"
							value="<?= tohtml(trim($v_app_name, "'")) ?>"
						>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_title" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Title")) ?><span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Supported variables")) ?>: {{appname}}, {{hostname}}, {{ip}} and {{page}} )</span>
						</label>
						<input
							type="text"
							class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
							name="v_title"
							id="v_title"
							value="<?= tohtml(trim($v_title, "'")) ?>"
						>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_from_name" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Sender Name")) ?><span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Default")) ?>: <?= tohtml(trim($v_app_name, "'")) ?>)</span>
						</label>
						<input
							type="text"
							class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
							name="v_from_name"
							id="v_from_name"
							value="<?= tohtml(trim($v_from_name, "'")) ?>"
						>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_from_email" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Sender Email Address")) ?><span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Default")) ?>: <?= tohtml(sprintf("noreply@%s", trim(get_hostname(), "'"))) ?>)</span>
						</label>
						<input
							type="email"
							class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
							name="v_from_email"
							id="v_from_email"
							value="<?= tohtml(trim($v_from_email, "'")) ?>"
						>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_subject_email" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Email Subject")) ?><span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Supported variables")) ?>: {{appname}}, {{hostname}}, {{subject}} )</span>
						</label>
						<input
							type="text"
							class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
							name="v_subject_email"
							id="v_subject_email"
							value="<?= tohtml(trim($v_subject_email, "'")) ?>"
						>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_hide_docs" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Hide link to Documentation")) ?>
						</label>
						<select x-model="hide_docs" class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_hide_docs" id="v_hide_docs">
							<option value="yes"><?= tohtml( _("Yes")) ?></option>
							<option value="no"><?= tohtml( _("No")) ?></option>
						</select>
					</div>
				</div>
			</details>
			<!-- Custom Logo options section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-gear u-mr15 mr-[15px]"></i>
					<?= tohtml( _("Custom Logo")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_custom_logo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Custom Logo")) ?>
						</label>
					</div>
					<div class="u-mb10 mb-[10px]">
						<p class="u-mb10 mb-[10px]"><?= tohtml(sprintf(_("Upload the files to %s"), "/usr/local/hestia/web/images/custom/")) ?></p>
						<ul>
							<li><code>logo.svg</code> <small>(100px x 120px)</small></li>
							<li><code>logo.png</code> <small>(100px x 120px)</small></li>
							<li><code>logo-header.svg</code> <small>(54px x 29px)</small></li>
							<li><code>favicon.png</code> <small>(64px x 64px)</small></li>
							<li><code>favicon.ico</code> <small>(16px x 16px)</small></li>
						</ul>
					</div>
					<div class="u-mb10 mb-[10px]">
						<input type="checkbox" id="v_update_logo" name="v_update_logo" value="yes">
						<label for="v_update_logo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Update logo")) ?>
						</label>
					</div>
					<div class="u-mb10 mb-[10px]">
						<input type="checkbox" id="v_reset_logo" name="v_reset_logo" value="yes">
						<label for="v_reset_logo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Reset Logo")) ?>
						</label>
					</div>
			</details>
		</div>
	</form>
</div>
<!-- End form -->
