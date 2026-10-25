<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/ip/">
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

	<form
		x-data="{
			showUserTable: <?= tohtml(empty($v_dedicated) ? "true" : "false") ?>
		}"
		id="main-form"
		name="v_add_ip"
		method="post"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add IP Address")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_ip" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("IP Address")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ip" id="v_ip" value="<?= tohtml(trim($v_ip, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_netmask" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Netmask")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_netmask" id="v_netmask" value="<?= tohtml(trim($v_netmask, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_interface" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Interface")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_interface" id="v_interface">
					<?php
						foreach ($interfaces as $key => $value) {
							echo "\t\t\t\t<option value=\"".htmlentities($value)."\"";
							if ((!empty($v_interface)) && ( $value == $v_interface )) echo ' selected';
							echo ">".htmlentities($value)."</option>\n";
						}
					?>
				</select>
			</div>
			<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
				<input x-model="showUserTable" class="form-check-input accent-blue-600" type="checkbox" name="v_shared" id="v_shared">
				<label for="v_shared">
					<?= tohtml( _("Shared")) ?>
				</label>
			</div>
			<div x-cloak x-show="!showUserTable" id="usrtable">
				<div class="u-mb10 mb-[10px]">
					<label for="v_owner" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Assigned User")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_owner" id="v_owner">
						<?php
							foreach ($users as $key => $value) {
								echo "\t\t\t\t<option value=\"".htmlentities($value)."\"";
								if ((!empty($v_owner)) && ( $value == $v_owner )) echo ' selected';
								echo ">".htmlentities($value)."</option>\n";
							}
						?>
					</select>
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_name" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Assigned Domain")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_name" id="v_name" value="<?= tohtml(trim($v_name, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_nat" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("NAT IP Association")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_nat" id="v_nat" value="<?= tohtml(trim($v_nat, "'")) ?>">
			</div>
		</div>

	</form>

</div>
