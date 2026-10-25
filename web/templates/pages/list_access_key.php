<?php
// Prevent resubmit form on page refresh
if (!empty($_POST["ok"])) { ?>
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
<?php } ?>

<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/access-key/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">
	<form id="main-form">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Access Key")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<?php if (!empty($key_data["ACCESS_KEY_ID"])) { ?>
				<div class="u-mt15 u-mb10 mt-[15px] mb-[10px]">
					<label for="access_key_id" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Access Key ID")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" id="access_key_id" maxlength="255" readonly value="<?= tohtml(trim($key_data["ACCESS_KEY_ID"], "'")) ?>">
				</div>
			<?php } ?>
			<?php if (!empty($_SESSION["ok_msg"])) { ?>
				<?php if (!empty($key_data["ACCESS_KEY_ID"]) && !empty($key_data["SECRET_ACCESS_KEY"])) { ?>
					<div class="u-mb20 mb-[20px]">
						<label for="secret_key" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Secret Key")) ?><br>
							<span class="inline-alert inline-alert-warning u-mb20 inline-flex items-center gap-1 text-sm font-medium text-amber-800 mb-[20px]"><?= tohtml( _("Warning! Last chance to save secret key!")) ?></span>
						</label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" id="secret_key" maxlength="255" readonly value="<?= tohtml(trim($key_data["SECRET_ACCESS_KEY"], "'")) ?>">
					</div>
				<?php } ?>
			<?php } ?>
			<p class="u-mb10 mb-[10px]"><?= tohtml( _("Permissions")) ?></p>
			<ul class="u-list-bulleted u-mb10 mb-[10px] list-disc pl-8">
				<?php foreach ($key_data["PERMISSIONS"] as $api_name) { ?>
					<li><?= tohtml( _($api_name)) ?></li>
				<?php } ?>
			</ul>
			<div class="u-mb10 mb-[10px]">
				<label for="service" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Comment")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" id="service" maxlength="255" readonly value="<?= tohtml(trim($key_data["COMMENT"], "'")) ?>">
			</div>
		</div>

	</form>

</div>
