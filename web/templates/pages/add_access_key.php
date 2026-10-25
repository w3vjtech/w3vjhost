<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/access-key/">
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
	<form id="main-form" name="v_add_access_key" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add Access Key")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<p class="u-mb10 mb-[10px]"><?= tohtml( _("Permissions")) ?></p>
			<?php foreach ($apis as $api_name => $api_data) { ?>
				<div class="form-check flex items-center gap-2">
					<input class="form-check-input accent-blue-600" type="checkbox" value="<?= tohtml($api_name) ?>" name="v_apis[]" id="v_apis_<?= tohtml($api_name) ?>" tabindex="5">
					<label for="v_apis_<?= tohtml($api_name) ?>">
						<?= tohtml( _($api_name)) ?>
					</label>
				</div>
			<?php } ?>
			<div class="u-mt15 mt-[15px]">
				<label for="v_comment" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Comment")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_comment" id="v_comment" maxlength="255">
			</div>
		</div>

	</form>

</div>
