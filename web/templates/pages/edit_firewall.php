<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/firewall/">
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

	<form id="main-form" name="v_edit_firewall" method="post" class="<?= tohtml($v_status) ?>">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit Firewall Rule")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_action" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Action")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_action" id="v_action">
					<option value="DROP" <?php if ((!empty($v_action)) && ( $v_action == "DROP" )) echo 'selected'?>><?= tohtml( _("DROP")) ?></option>
					<option value="ACCEPT" <?php if ((!empty($v_action)) && ( $v_action == "ACCEPT" )) echo 'selected'?>><?= tohtml( _("ACCEPT")) ?></option>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_protocol" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Protocol")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_protocol" id="v_protocol">
					<option value="TCP" <?php if ((!empty($v_protocol)) && ( $v_protocol == "TCP" )) echo 'selected'?>>TCP</option>
					<option value="UDP" <?php if ((!empty($v_protocol)) && ( $v_protocol == "UDP" )) echo 'selected'?>>UDP</option>
					<option value="ICMP" <?php if ((!empty($v_protocol)) && ( $v_protocol == "ICMP" )) echo 'selected'?>>ICMP</option>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_port" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Port")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Ranges and lists are acceptable")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_port" id="v_port" value="<?= tohtml(trim($v_port, "'")) ?>" placeholder="<?= tohtml( _("All ports: 0, Range: 80-82, List: 80,443,8080,8443")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_ip" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("IP Address / IPset IP List")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Support CIDR format")) ?>)</span>
				</label>
				<div class="u-pos-relative relative">
					<select
						class="form-select js-ip-list-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
						tabindex="-1"
						onchange="this.nextElementSibling.value=this.value"
						data-ipset-lists="<?= tohtml($ipset_lists_json) ?>"
					>
						<option value=""><?= tohtml( _("Clear")) ?></option>
					</select>
					<input type="text" class="form-control list-editor block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 absolute inset-x-1 top-0.5 w-auto! py-1!" name="v_ip" id="v_ip" value="<?= tohtml(trim($v_ip, "'")) ?>">
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_comment" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Comment")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_comment" id="v_comment" maxlength="255" value="<?= tohtml(trim($v_comment, "'")) ?>">
			</div>
		</div>

	</form>

</div>
