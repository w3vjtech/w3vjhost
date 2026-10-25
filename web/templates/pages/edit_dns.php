<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/dns/">
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

	<form id="main-form" name="v_edit_dns" method="post" class="<?= tohtml($v_status) ?>">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit DNS Domain")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_domain" id="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>" disabled required>
				<input type="hidden" name="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_ip" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("IP Address")) ?></label>
				<div class="u-pos-relative relative">
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" tabindex="-1" onchange="this.nextElementSibling.value=this.value">
						<option value="">clear</option>
						<?php
							foreach ($v_ips as $ip => $value) {
								$display_ip = empty($value['NAT']) ? $ip : "{$value['NAT']}";
								$ip_selected = ((!empty($v_ip) && ($v_ip==$ip||$v_ip==$display_ip) ))? 'selected' : '';
								echo "<option value='{$display_ip}' {$ip_selected}>" . htmlentities($display_ip) . "</option>\n";
							}
						?>
					</select>
					<input type="text" class="form-control list-editor block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 absolute inset-x-1 top-0.5 w-auto! py-1!" name="v_ip" id="v_ip" value="<?= tohtml(trim($v_ip, "'")) ?>">
				</div>
			</div>
			<?php if ($_SESSION["userContext"] === "admin" || ($_SESSION["userContext"] === "user" && $_SESSION["POLICY_USER_EDIT_DNS_TEMPLATES"] === "yes")) { ?>
				<div class="u-mb10 mb-[10px]">
					<label for="v_template" class="form-label mb-1 block text-sm font-semibold text-slate-700">
						<?= tohtml( _("Template")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["DNS_SYSTEM"])) ?></span>
					</label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_template" id="v_template">
						<?php
							foreach ($templates as $key => $value) {
								echo "\t\t\t\t<option value=\"".htmlentities($value)."\"";
								$svalue = "'".$value."'";
								if ((!empty($v_template)) && ( $value == $v_template ) || ($svalue == $v_template)){
									echo ' selected' ;
								}
								echo ">".htmlentities($value)."</option>\n";
							}
						?>
					</select>
				</div>
			<?php } ?>
			<?php if ($_SESSION["DNS_CLUSTER_SYSTEM"] == "hestia-zone" && $_SESSION["SUPPORT_DNSSEC"] == "yes") { ?>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input class="form-check-input accent-blue-600" type="checkbox" name="v_dnssec" id="v_dnssec" value="yes" <?php if ($v_dnssec === 'yes'){ echo ' checked'; } ?>>
					<label for="v_dnssec">
						<?= tohtml( _("Enable DNSSEC")) ?>
					</label>
				</div>
			<?php } ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_exp" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Expiration Date")) ?><span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("YYYY-MM-DD")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_exp" id="v_exp" value="<?= tohtml(trim($v_exp, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_soa" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("SOA")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_soa" id="v_soa" value="<?= tohtml(trim($v_soa, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_ttl" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("TTL")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ttl" id="v_ttl" value="<?= tohtml(trim($v_ttl, "'")) ?>">
			</div>
		</div>

	</form>

</div>
