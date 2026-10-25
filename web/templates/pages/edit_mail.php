<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/mail/">
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
			sslEnabled: <?= tohtml($v_ssl == "yes" ? "true" : "false") ?>,
			letsEncryptEnabled: <?= tohtml($v_letsencrypt == "yes" ? "true" : "false") ?>,
			hasSmtpRelay: <?= tohtml($v_smtp_relay == "true" ? "true" : "false") ?>,
			dkimEnabled: <?= tohtml($v_dkim == "yes" ? "true" : "false") ?>
		}"
		id="main-form"
		name="v_edit_mail"
		method="post"
		class="<?= tohtml($v_status) ?> js-enable-inputs-on-submit"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit Mail Domain")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb20 mb-[20px]">
				<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_domain" id="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>" disabled required>
				<input type="hidden" name="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>">
			</div>
			<?php if ($_SESSION["WEBMAIL_SYSTEM"]) { ?>
				<div class="u-mb10 mb-[10px]">
					<label for="v_webmail" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Webmail Client")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_webmail" id="v_webmail" tabindex="6">
						<?php foreach ($webmail_clients as $client){
							echo "\t\t\t\t<option value=\"".htmlentities($client)."\"";
							if (( htmlentities(trim($v_webmail,"'")) == $client )) {
								echo ' selected' ;
							}
							echo ">".htmlentities(ucfirst($client))."</option>\n";
							}
						?>
						<option value="disabled" <?php if (htmlentities(trim($v_webmail,"'")) == 'disabled') { echo "selected"; }?>><?= tohtml( _("Disabled")) ?></option>
					</select>
				</div>
			<?php } ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_catchall" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Catch-All Email")) ?></label>
				<input type="email" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_catchall" id="v_catchall" value="<?= tohtml(trim($v_catchall, "'")) ?>">
			</div>
			<div class="u-mb20 mb-[20px]">
				<label for="v_rate" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Rate Limit")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("email / hour / account")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_rate" id="v_rate" value="<?= tohtml(trim($v_rate, "'")) ?>" <?php if ($_SESSION['userContext'] != "admin"){ echo "disabled"; }?>>
			</div>
			<?php if (!empty($_SESSION["ANTISPAM_SYSTEM"])) { ?>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input class="form-check-input accent-blue-600" type="checkbox" name="v_antispam" id="v_antispam" <?php if ($v_antispam == 'yes') echo 'checked'; ?>>
					<label for="v_antispam">
						<?= tohtml( _("Spam Filter")) ?>
					</label>
				</div>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input class="form-check-input accent-blue-600" type="checkbox" name="v_reject" id="v_reject" <?php if ($v_reject == 'yes') echo 'checked'; ?>>
					<label for="v_reject">
						<?= tohtml( _("Reject Spam")) ?>
					</label>
				</div>
			<?php } ?>
			<?php if (!empty($_SESSION["ANTIVIRUS_SYSTEM"])) { ?>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input class="form-check-input accent-blue-600" type="checkbox" name="v_antivirus" id="v_antivirus" <?php if ($v_antivirus == 'yes') echo 'checked'; ?>>
					<label for="v_antivirus">
						<?= tohtml( _("Anti-Virus")) ?>
					</label>
				</div>
			<?php } ?>
			<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
				<input x-model="dkimEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_dkim" id="v_dkim" <?php if ($v_dkim == 'yes') echo 'checked'; ?>>
				<label for="v_dkim">
					<?= tohtml( _("DKIM Support")) ?>
				</label>
			</div>
			<div x-cloak x-show="dkimEnabled" class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
				<label for="v_dkim_selector" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					DKIM Selector <span class="optional text-xs font-normal text-slate-500">(<?= _("Use a-z, 0-9, hyphen; no leading, trailing or consecutive hyphens") ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_dkim_selector" id="v_dkim_selector" value="<?= tohtml(empty($v_dkim_selector) ? "mail" : trim($v_dkim_selector, "'")) ?>">
			</div>
			<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
				<input x-model="sslEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_ssl" id="v_ssl">
				<label for="v_ssl">
					<?= tohtml( _("Enable SSL for this domain")) ?>
				</label>
			</div>
			<div x-cloak x-show="sslEnabled" class="u-pl30 pl-[30px]">
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input x-model="letsEncryptEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_letsencrypt" id="v_letsencrypt">
					<label for="v_letsencrypt">
						<?= tohtml( _("Use Let's Encrypt to obtain SSL certificate")) ?>
					</label>
				</div>
				<div x-cloak x-show="letsEncryptEnabled" id="v_ssl_key_algo_wrapper" class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
					<label for="v_ssl_key_algo" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Key Type")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_ssl_key_algo" id="v_ssl_key_algo">
						<option value="ecdsa-256" <?php if ($v_ssl_key_algo == "ecdsa-256" || $v_ssl_key_algo == "ecdsa") echo 'selected'; ?>>
							ECDSA P-256 (<?= tohtml( _("recommended")) ?>)
						</option>
						<option value="ecdsa-384" <?php if ($v_ssl_key_algo == "ecdsa-384") echo 'selected'; ?>>
							ECDSA P-384
						</option>
						<option value="rsa" <?php if ($v_ssl_key_algo == "rsa") echo 'selected'; ?>>
							RSA 4096
						</option>
					</select>
				</div>
				<div class="alert alert-info u-mb20 mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-blue-200 bg-blue-50 text-blue-800 mb-[20px]" role="alert">
					<i class="fas fa-exclamation"></i>
					<div>
						<p><?= tohtml($v_webmail_alias) ?></p>
						<p><?= tohtml(sprintf(_("To enable Let's Encrypt SSL, ensure that DNS records exist for mail.%s and %s!"), $v_domain, $v_webmail_alias)) ?></p>
					</div>
				</div>
				<div x-cloak x-show="!letsEncryptEnabled">
					<div class="u-mb10 mb-[10px]">
						<label for="v_ssl_crt" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("SSL Certificate")) ?>
							<span x-cloak x-show="!letsEncryptEnabled" id="generate-csr" > / <a class="form-link inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50" target="_blank" href="/generate/ssl/?<?= tohtml(http_build_query(["domain" => $v_domain])) ?>"><?= tohtml( _("Generate Self-Signed SSL Certificate")) ?></a></span>
						</label>
						<textarea x-bind:disabled="letsEncryptEnabled" class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight" name="v_ssl_crt" id="v_ssl_crt"><?= tohtml(trim($v_ssl_crt, "'")) ?></textarea>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_ssl_key" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("SSL Private Key")) ?></label>
						<textarea x-bind:disabled="letsEncryptEnabled" class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight" name="v_ssl_key" id="v_ssl_key"><?= tohtml(trim($v_ssl_key, "'")) ?></textarea>
					</div>
					<div class="u-mb20 mb-[20px]">
						<label for="v_ssl_ca" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("SSL Certificate Authority / Intermediate")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
						</label>
						<textarea x-bind:disabled="letsEncryptEnabled" class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight" name="v_ssl_ca" id="v_ssl_ca"><?= tohtml(trim($v_ssl_ca, "'")) ?></textarea>
					</div>
				</div>
				<?php if ($v_ssl != "no") { ?>
					<ul class="values-list u-mb20 mb-[20px]">
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Issued To")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_subject) ?></span>
						</li>
						<?php if ($v_ssl_aliases) {
							$v_ssl_aliases = str_replace(",", ", ", $v_ssl_aliases); ?>
							<li class="values-list-item flex flex-wrap gap-2 py-1">
								<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Alternate")) ?></span>
								<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_aliases) ?></span>
							</li>
						<?php } ?>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Not Before")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_not_before) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Not After")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_not_after) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Signature")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_signature) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Key Size")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_pub_key) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Issued By")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_issuer) ?></span>
						</li>
					</ul>
				<?php } ?>
			</div>
			<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
				<input x-model="hasSmtpRelay" class="form-check-input accent-blue-600" type="checkbox" name="v_smtp_relay" id="v_smtp_relay">
				<label for="v_smtp_relay">
					<?= tohtml( _("SMTP Relay")) ?>
				</label>
			</div>
			<div x-cloak x-show="hasSmtpRelay" id="smtp_relay_table" class="u-pl30 pl-[30px]">
				<div class="u-mb10 mb-[10px]">
					<label for="v_smtp_relay_host" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Host")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_host" id="v_smtp_relay_host" value="<?= tohtml(trim($v_smtp_relay_host, "'")) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_smtp_relay_port" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Port")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_port" id="v_smtp_relay_port" value="<?= tohtml(trim($v_smtp_relay_port, "'")) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_smtp_relay_user" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Username")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_user" id="v_smtp_relay_user" value="<?= tohtml(trim($v_smtp_relay_user, "'")) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_smtp_relay_pass" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Password")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_pass" id="v_smtp_relay_pass">
				</div>
			</div>
		</div>

	</form>

</div>
