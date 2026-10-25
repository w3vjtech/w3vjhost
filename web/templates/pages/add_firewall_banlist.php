<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/firewall/banlist/">
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

	<form id="main-form" name="v_add_ip" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add IP Address to Banlist")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb20 mb-[20px]">
				<label for="v_ip" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("IP Address")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Support CIDR format")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ip" id="v_ip" value="<?= tohtml(trim($v_ip, "'")) ?>" required>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_chain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Banlist")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_chain" id="v_chain">
					<option value="SSH" <?php if ((!empty($v_chain)) && ( $v_chain == "'SSH'" )) echo 'selected'?>><?= tohtml( _("SSH")) ?></option>
					<option value="WEB" <?php if ((!empty($v_chain)) && ( $v_chain == "'WEB'" )) echo 'selected'?>><?= tohtml( _("WEB")) ?></option>
					<option value="FTP" <?php if ((!empty($v_chain)) && ( $v_chain == "'FTP'" )) echo 'selected'?>><?= tohtml( _("FTP")) ?></option>
					<option value="DNS" <?php if ((!empty($v_chain)) && ( $v_chain == "'DNS'" )) echo 'selected'?>><?= tohtml( _("DNS")) ?></option>
					<option value="MAIL" <?php if ((!empty($v_chain)) && ( $v_chain == "'MAIL'" )) echo 'selected'?>><?= tohtml( _("MAIL")) ?></option>
					<option value="DB" <?php if ((!empty($v_chain)) && ( $v_chain == "'DB'" )) echo 'selected'?>><?= tohtml( _("DB")) ?></option>
					<option value="HESTIA" <?php if ((!empty($v_chain)) && ( $v_chain == "'HESTIA'" )) echo 'selected'?>><?= tohtml( _("HESTIA")) ?></option>
				</select>
			</div>
		</div>

	</form>

</div>
