<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
				<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/dns/?<?= tohtml(http_build_query(array("domain" => trim($v_domain, "'"), "token" => $_SESSION["token"]))) ?>">
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

	<form id="main-form" name="v_edit_dns_rec" method="post" class="<?= tohtml($v_status) ?>">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit DNS Record")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
				<input type="text" class="form-control js-dns-record-domain block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_domain" id="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>" disabled>
				<input type="hidden" name="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_rec" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Record")) ?></label>
				<input type="text" class="form-control js-dns-record-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_rec" id="v_rec" value="<?= tohtml(trim($v_rec, "'")) ?>">
				<input type="hidden" name="v_record_id" value="<?= tohtml(trim($v_record_id, "'")) ?>">
				<small class="hint text-sm leading-6 text-slate-500"></small>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_type" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Type")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_type" id="v_type">
					<option value="A" <?php if ($v_type == 'A') echo "selected"; ?>>A</option>
					<option value="AAAA" <?php if ($v_type == 'AAAA') echo "selected"; ?>>AAAA</option>
					<option value="CAA" <?php if ($v_type == 'CAA') echo "selected"; ?>>CAA</option>
					<option value="CNAME" <?php if ($v_type == 'CNAME') echo "selected"; ?>>CNAME</option>
					<option value="DNSKEY" <?php if ($v_type == 'DNSKEY') echo "selected"; ?>>DNSKEY</option>
					<option value="DS" <?php if ($v_type == 'DS') echo "selected"; ?>>DS</option>
					<option value="IPSECKEY" <?php if ($v_type == 'IPSECKEY') echo "selected"; ?>>IPSECKEY</option>
					<option value="KEY" <?php if ($v_type == 'KEY') echo "selected"; ?>>KEY</option>
					<option value="MX" <?php if ($v_type == 'MX') echo "selected"; ?>>MX</option>
					<option value="NS" <?php if ($v_type == 'NS') echo "selected"; ?>>NS</option>
					<option value="PTR" <?php if ($v_type == 'PTR') echo "selected"; ?>>PTR</option>
					<option value="SPF" <?php if ($v_type == 'SPF') echo "selected"; ?>>SPF</option>
					<option value="SRV" <?php if ($v_type == 'SRV') echo "selected"; ?>>SRV</option>
					<option value="TLSA" <?php if ($v_type == 'TLSA') echo "selected"; ?>>TLSA</option>
					<option value="TXT" <?php if ($v_type == 'TXT') echo "selected"; ?>>TXT</option>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_val" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("IP or Value")) ?></label>
				<div class="u-pos-relative relative">
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" tabindex="-1" onchange="this.nextElementSibling.value=this.value">
						<option value="">&nbsp;</option>
						<?php
							foreach ($v_ips as $ip => $value) {
								$display_ip = empty($value['NAT']) ? $ip : "{$value['NAT']}";
								echo "<option value='{$display_ip}'>" . htmlentities($display_ip) . "</option>\n";
							}
						?>
					</select>
					<input type="text" class="form-control list-editor block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 absolute inset-x-1 top-0.5 w-auto! py-1!" name="v_val" id="v_val" value="<?= tohtml(trim($v_val, "'")) ?>">
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_priority" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Priority")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_priority" id="v_priority" value="<?= tohtml(trim($v_priority, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_ttl" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("TTL")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ttl" id="v_ttl" value="<?= tohtml(trim($v_ttl, "'")) ?>">
			</div>
		</div>

	</form>

</div>
