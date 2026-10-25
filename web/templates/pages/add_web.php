<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/web/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if (($_SESSION["role"] == "admin" && $accept === "true") || $_SESSION["role"] !== "admin") { ?>
				<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" form="main-form">
					<i class="fas fa-floppy-disk icon-purple text-purple-700"></i><?= tohtml( _("Save")) ?>
				</button>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<form id="main-form" name="v_add_web" method="post" class="js-enable-inputs-on-submit">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add Web Domain")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<?php if ($_SESSION["role"] == "admin" && $accept !== "true") { ?>
				<div class="alert alert-danger mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-red-200 bg-red-50 text-red-800" role="alert">
					<i class="fas fa-exclamation"></i>
					<p><?= htmlify_trans(sprintf(_("It is strongly advised to {create a standard user account} before adding %s to the server due to the increased privileges the admin account possesses and potential security risks."), _('a web domain')), '</a>', '<a href="/add/user/">') ?></p>
				</div>
			<?php } ?>
			<?php if ($_SESSION["role"] == "admin" && empty($accept)) { ?>
				<div class="u-side-by-side u-mt20 flex flex-wrap items-center gap-2 mt-[20px]">
					<a href="/add/user/" class="button u-width-full u-mr10 inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 mr-[10px] w-full"><?= tohtml( _("Add User")) ?></a>
					<a href="/add/web/?<?= tohtml(http_build_query(["accept" => 'true'])) ?>" class="button button-danger u-width-full u-ml10 inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-red-200! bg-white! text-red-700! hover:bg-red-50! ml-[10px] w-full"><?= tohtml( _("Continue")) ?></a>
				</div>
			<?php } ?>
			<?php if (($_SESSION["role"] == "admin" && $accept === "true") || $_SESSION["role"] !== "admin") { ?>
				<div class="u-mb10 mb-[10px]">
					<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_domain" id="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>" required>
				</div>
				<div class="u-mb20 mb-[20px]">
					<label for="v_ip" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("IP Address")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_ip" id="v_ip">
						<?php
							foreach ($ips as $ip => $value) {
								$display_ip = htmlentities(empty($value['NAT']) ? $ip : "{$value['NAT']}");
								$ip_selected = (!empty($v_ip) && $ip == $_POST['v_ip']) ? 'selected' : '';
								echo "\t\t\t\t<option value=\"{$ip}\" {$ip_selected}>{$display_ip}</option>\n";
							}
						?>
					</select>
				</div>
				<?php if (isset($_SESSION["DNS_SYSTEM"]) && !empty($_SESSION["DNS_SYSTEM"])) { ?>
					<?php if ($panel[$user_plain]["DNS_DOMAINS"] != "0") { ?>
						<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
							<input class="form-check-input accent-blue-600" type="checkbox" name="v_dns" id="v_dns" <?php if (empty($v_dns) && $panel[$user_plain]["DNS_DOMAINS"] != "0"); ?>>
							<label for="v_dns">
								<?= tohtml( _("DNS Support")) ?>
							</label>
						</div>
					<?php } ?>
				<?php } ?>
				<?php if (isset($_SESSION["IMAP_SYSTEM"]) && !empty($_SESSION["IMAP_SYSTEM"])) { ?>
					<?php if ($panel[$user_plain]["MAIL_DOMAINS"] != "0") { ?>
						<div class="form-check flex items-center gap-2">
							<input class="form-check-input accent-blue-600" type="checkbox" name="v_mail" id="v_mail" <?php if (empty($v_mail) && $panel[$user_plain]["MAIL_DOMAINS"] != "0"); ?>>
							<label for="v_mail">
								<?= tohtml( _("Mail Support")) ?>
							</label>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>

	</form>

</div>
