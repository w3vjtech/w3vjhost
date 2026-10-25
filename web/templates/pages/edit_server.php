<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a href="/list/server/" class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<a href="/list/ip/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-ethernet icon-blue text-blue-700"></i><?= tohtml( _("Network")) ?>
			</a>
			<a href="/edit/server/whitelabel/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-paint-brush icon-blue text-blue-700"></i><?= tohtml( _("White Label")) ?>
			</a>
			<a href="/edit/server/hestiaweb/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-clock icon-blue text-blue-700"></i><?= tohtml( _("Panel Cronjobs")) ?>
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
		<?php
			$server_x_data = [
				"timezone" => $v_timezone ?? "",
				"theme" => $_SESSION["THEME"],
				"language" => $_SESSION["LANGUAGE"],
				"hasSmtpRelay" => $v_smtp_relay == "true",
				"remoteBackupEnabled" => !empty($v_backup_remote_adv),
				"incrementalBackups" => $v_backup_incremental ?? "",
				"backupType" => !empty($v_backup_type) ? trim($v_backup_type, "'") : "",
				"webmailAlias" => $_SESSION["WEBMAIL_ALIAS"] ?? "",
				"apiSystem" => $_SESSION["API_SYSTEM"],
				"legacyApi" => $_SESSION["API"],
			];
		?>
			<form
				x-data="<?= tohtml(json_encode($server_x_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR)) ?>"
				id="main-form"
				name="v_configure_server"
				method="post"
			>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]">
				<?= tohtml( _("Configure Server")) ?>
			</h1>
			<?php show_alert_message($_SESSION); ?>

			<!-- Basic options section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-gear u-mr10 mr-[10px]"></i><?= tohtml( _("Basic Options")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_hostname" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Hostname")) ?>
						</label>
						<input
							type="text"
							class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
							name="v_hostname"
							id="v_hostname"
							value="<?= tohtml(trim($v_hostname, "'")) ?>"
						>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_timezone" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Time Zone")) ?>
						</label>
						<select x-model="timezone" class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_timezone" id="v_timezone">
							<?php foreach ($v_timezones as $key => $value) { ?>
								<option value="<?= tohtml($value) ?>">
									<?= tohtml($value) ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_theme" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Theme")) ?>
						</label>
						<select x-model="theme" class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_theme" id="v_theme">
							<?php foreach ($theme as $key => $value) { ?>
								<option value="<?= tohtml($value) ?>">
									<?= tohtml($value) ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-check u-mb20 flex items-center gap-2 mb-[20px]">
						<input
							class="form-check-input accent-blue-600"
							type="checkbox"
							name="v_policy_user_change_theme"
							id="v_policy_user_change_theme"
							<?= tohtml($_SESSION["POLICY_USER_CHANGE_THEME"] == "no" ? "checked" : "") ?>
						>
						<label for="v_policy_user_change_theme">
							<?= tohtml( _("Set as selected theme for all users")) ?>
						</label>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_language" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Default Language")) ?></label>
						<select x-model="language" class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_language" id="v_language">
							<?php foreach ($languages as $key => $value) { ?>
								<option value="<?= tohtml($key) ?>">
									<?= tohtml($value) ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
						<input
							class="form-check-input accent-blue-600"
							type="checkbox"
							name="v_language_update"
							id="v_language_update"
						>
						<label for="v_language_update">
							<?= tohtml( _("Set as default language for all users")) ?>
						</label>
					</div>
					<div class="form-check flex items-center gap-2">
						<input
							class="form-check-input accent-blue-600"
							type="checkbox"
							name="v_debug_mode"
							id="v_debug_mode"
							<?= tohtml($_SESSION["DEBUG_MODE"] == "true" ? "checked" : "") ?>
						>
						<label for="v_debug_mode">
							<?= tohtml( _("Enable debug mode")) ?>
						</label>
					</div>
				</div>
			</details>

			<!-- Updates section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-code-branch u-mr10 mr-[10px]"></i><?= tohtml( _("Updates")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<p class="u-mb10 mb-[10px]">
						<?= tohtml( _("Version")) ?>:
						<span class="optional text-xs font-normal text-slate-500">
							<?= tohtml($_SESSION["VERSION"]) ?>
						</span>
					</p>
					<?php if ($_SESSION["RELEASE_BRANCH"] !== "release") { ?>
						<p class="u-mb10 mb-[10px]">
							<?= tohtml( _("Release")) ?>:
							<span class="optional text-xs font-normal text-slate-500">
								<?= tohtml($_SESSION["RELEASE_BRANCH"]) ?>
							</span>
						</p>
					<?php } ?>
					<p class="u-mb5 mb-[5px]">
						<?= tohtml( _("Options")) ?>
					</p>
					<div class="form-check flex items-center gap-2">
						<input
							class="form-check-input accent-blue-600"
							type="checkbox"
							name="v_experimental_features"
							id="v_experimental_features"
							<?= tohtml($_SESSION["POLICY_SYSTEM_ENABLE_BACON"] == "true" ? "checked" : "") ?>
						>
						<label for="v_experimental_features">
							<?= tohtml( _("Enable preview features")) ?>
						</label>
						<span class="hint text-sm leading-6 text-slate-500">
							<a href="/list/server/preview/">
								(<?= tohtml( _("View")) ?>)
							</a>
						</span>
					</div>
					<div class="form-check flex items-center gap-2">
						<input
							class="form-check-input accent-blue-600"
							type="checkbox"
							name="v_upgrade_send_notification_email"
							id="v_upgrade_send_notification_email"
							<?= tohtml($_SESSION["UPGRADE_SEND_EMAIL"] == "true" ? "checked" : "") ?>
						>
						<label for="v_upgrade_send_notification_email">
							<?= tohtml( _("Send email notification when an update has been installed")) ?>
						</label>
					</div>
					<div class="form-check flex items-center gap-2">
						<input
							class="form-check-input accent-blue-600"
							type="checkbox"
							name="v_upgrade_send_email_log"
							id="v_upgrade_send_email_log"
							<?= tohtml($_SESSION["UPGRADE_SEND_EMAIL_LOG"] == "true" ? "checked" : "") ?>
						>
						<label for="v_upgrade_send_email_log">
							<?= tohtml( _("Send update installation log by email")) ?>
						</label>
					</div>
				</div>
			</details>

			<!-- Web Server section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-earth-americas u-mr10 mr-[10px]"></i><?= tohtml( _("Web Server")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<?php if (!empty($_SESSION["PROXY_SYSTEM"])) { ?>
						<p>
							<?= tohtml( _("Proxy Server")) ?>:
							<span class="u-ml5 ml-[5px]">
								<?= tohtml($_SESSION["PROXY_SYSTEM"]) ?>
							</span>
							<a href="/edit/server/<?= tohtml(rawurlencode($_SESSION["PROXY_SYSTEM"])) ?>/" class="u-ml5 ml-[5px]">
								<i class="fas fa-pencil icon-orange text-amber-700"></i>
							</a>
						</p>
					<?php } ?>
					<?php if (!empty($_SESSION["WEB_SYSTEM"])) { ?>
						<p>
							<?= tohtml( _("Web Server")) ?>:
							<span class="u-ml5 ml-[5px]">
								<?= tohtml($_SESSION["WEB_SYSTEM"]) ?>
							</span>
							<a href="/edit/server/<?= tohtml(rawurlencode($_SESSION["WEB_SYSTEM"])) ?>/" class="u-ml5 ml-[5px]">
								<i class="fas fa-pencil icon-orange text-amber-700"></i>
							</a>
						</p>
					<?php } ?>
					<?php if (!empty($_SESSION["WEB_BACKEND"])) { ?>
						<p>
							<?= tohtml( _("PHP Interpreter")) ?>:
							<span class="u-ml5 ml-[5px]">
								<?= tohtml($_SESSION["WEB_BACKEND"]) ?>
							</span>
							<a href="/edit/server/<?= tohtml(rawurlencode($_SESSION["WEB_BACKEND"])) ?>/" class="u-ml5 ml-[5px]">
								<i class="fas fa-pencil icon-orange text-amber-700"></i>
							</a>
						</p>
					<?php } ?>
					<?php if (!empty($_SESSION["WEB_BACKEND_POOL"])) { ?>
						<p>
							<?= tohtml( _("Backend Pool Mode")) ?>:
							<span class="u-ml5 ml-[5px]">
								<?= tohtml($_SESSION["WEB_BACKEND_POOL"]) ?>
							</span>
						</p>
					<?php } ?>
					<?php if (count($v_php_versions)) { ?>
						<div class="u-mt15 mt-[15px]">
							<p class="u-mb10 mb-[10px]">
								<?= tohtml( _("Enabled PHP Versions")) ?>
							</p>
							<div class="alert alert-info u-mb10 mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-blue-200 bg-blue-50 text-blue-800 mb-[10px]" role="alert">
								<i class="fas fa-info"></i>
								<p><?= tohtml( _("It may take a few minutes to save your changes. Please wait until the process has completed and do not refresh the page.")) ?></p>
							</div>
						</div>
						<?php foreach ($v_php_versions as $php_version) { ?>
							<div class="form-check flex items-center gap-2">
								<input
									class="form-check-input accent-blue-600"
									type="checkbox"
									id="<?= tohtml($php_version->name) ?>"
									name="v_php_versions[<?= tohtml($php_version->tpl) ?>]"
									<?= tohtml($php_version->installed ? "checked" : "") ?>
									<?= tohtml($php_version->protected ? "disabled" : "") ?>
								>
								<label for="<?= tohtml($php_version->name) ?>">
									<?= tohtml($php_version->name) ?>
								</label>
							</div>
							<?php foreach ($php_version->usedby as $wd_user => $wd_domains) { ?>
								<?php foreach ($wd_domains as $wd_domain) { ?>
									<p class="u-side-by-side flex flex-wrap items-center gap-2 px-[10px]">
										<span>
											<i class="fas fa-user"></i>
											<?= tohtml($wd_user) ?>
										</span>
										<span class="optional text-xs font-normal text-slate-500"><?= tohtml($wd_domain) ?></span>
									</p>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php if (!empty($_SESSION["WEB_BACKEND"])) { ?>
						<div class="u-mt10 mt-[10px]">
							<label for="v_php_default_version" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("System PHP Version")) ?>
							</label>
							<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_php_default_version" id="v_php_default_version">
								<?php foreach ($v_php_versions as $php_version) { ?>
									<?php if ($php_version->installed) { ?>
										<option
											value="<?= tohtml($php_version->version) ?>"
											<?= tohtml($php_version->name == DEFAULT_PHP_VERSION ? "selected" : "") ?>
										>
											<?= tohtml($php_version->name) ?>
										</option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					<?php } ?>
				</div>
			</details>

			<!-- Application Runtimes section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-cubes u-mr10 mr-[10px]"></i><?= tohtml( _("Application Runtimes")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="alert alert-info u-mb10 mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-blue-200 bg-blue-50 text-blue-800 mb-[10px]" role="alert">
						<i class="fas fa-info"></i>
						<p><?= tohtml( _("It may take a few minutes to save your changes. Please wait until the process has completed and do not refresh the page.")) ?></p>
					</div>
					<?php foreach ([
						"nodejs" => [_("Enabled Node.js Versions"), _("System Node.js Version"), $v_nodejs_versions],
						"python" => [_("Enabled Python Versions"), _("System Python Version"), $v_python_versions],
					] as $runtime => [$runtime_title, $runtime_default_label, $runtime_versions]) { ?>
						<div class="u-mt15 mt-[15px]">
							<p class="u-mb10 mb-[10px]">
								<?= tohtml($runtime_title) ?>
							</p>
						</div>
						<?php foreach ($runtime_versions as $runtime_version) { ?>
							<div class="form-check flex items-center gap-2">
								<input
									class="form-check-input accent-blue-600"
									type="checkbox"
									id="<?= tohtml($runtime_version->name) ?>"
									name="v_<?= tohtml($runtime) ?>_versions[<?= tohtml($runtime_version->tpl) ?>]"
									<?= tohtml($runtime_version->installed ? "checked" : "") ?>
									<?= tohtml($runtime_version->protected ? "disabled" : "") ?>
								>
								<label for="<?= tohtml($runtime_version->name) ?>">
									<?= tohtml($runtime_version->name) ?>
								</label>
							</div>
							<?php foreach ($runtime_version->usedby as $wd_user => $wd_domains) { ?>
								<?php foreach ($wd_domains as $wd_domain) { ?>
									<p class="u-side-by-side flex flex-wrap items-center gap-2 px-[10px]">
										<span>
											<i class="fas fa-user"></i>
											<?= tohtml($wd_user) ?>
										</span>
										<span class="optional text-xs font-normal text-slate-500"><?= tohtml($wd_domain) ?></span>
									</p>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<div class="u-mt10 mt-[10px]">
							<label for="v_<?= tohtml($runtime) ?>_default_version" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml($runtime_default_label) ?>
							</label>
							<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_<?= tohtml($runtime) ?>_default_version" id="v_<?= tohtml($runtime) ?>_default_version">
								<?php foreach ($runtime_versions as $runtime_version) { ?>
									<?php if ($runtime_version->installed) { ?>
										<option
											value="<?= tohtml($runtime_version->version) ?>"
											<?= tohtml($runtime_version->default ? "selected" : "") ?>
										>
											<?= tohtml($runtime_version->name) ?>
										</option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					<?php } ?>
				</div>
			</details>

			<!-- DNS Server section -->
			<?php if (!empty($_SESSION["DNS_SYSTEM"])) { ?>
				<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
					<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
						<i class="fas fa-book-atlas u-mr10 mr-[10px]"></i><?= tohtml( _("DNS Server")) ?>
					</summary>
					<div class="box-collapse-content p-4">
						<p>
							<?= tohtml( _("DNS Server")) ?>:
							<span class="u-ml5 ml-[5px]">
								<?= tohtml($_SESSION["DNS_SYSTEM"]) ?>
							</span>
							<a href="/edit/server/<?= tohtml(rawurlencode($_SESSION["DNS_SYSTEM"])) ?>/" class="u-ml5 ml-[5px]">
								<i class="fas fa-pencil icon-orange text-amber-700"></i>
							</a>
						</p>
						<p>
							<?= tohtml( _("DNS Cluster")) ?>:
							<span class="u-ml5 ml-[5px]">
								<?= tohtml($v_dns_cluster == "yes" ? _("Yes") : _("No")) ?>
							</span>
						</p>
						<?php if ($v_dns_cluster == "yes") {
							$i = 0;
							foreach ($dns_cluster as $key => $value) {
								$i++;
							?>
							<div>
								<label for="v_dns_remote_host" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Host") . " #" . $i) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_dns_remote_host"
									id="v_dns_remote_host"
									value="<?= tohtml($key) ?>"
									disabled
								>
							</div>
						<?php } } ?>
					</div>
				</details>
			<?php } ?>

			<!-- Mail Server section -->
			<?php if (!empty($_SESSION["MAIL_SYSTEM"])) { ?>
				<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
					<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
						<i class="fas fa-envelopes-bulk u-mr10 mr-[10px]"></i><?= tohtml( _("Mail Server")) ?>
					</summary>
					<div class="box-collapse-content p-4">
						<p>
							<?= tohtml( _("Mail Server")) ?>:
							<span class="u-ml5 ml-[5px]">
								<?= tohtml($_SESSION["MAIL_SYSTEM"]) ?>
							</span>
							<a href="/edit/server/<?= tohtml(rawurlencode($_SESSION["MAIL_SYSTEM"])) ?>/" class="u-ml5 ml-[5px]">
								<i class="fas fa-pencil icon-orange text-amber-700"></i>
							</a>
						</p>
						<?php if (!empty($_SESSION["ANTIVIRUS_SYSTEM"])) { ?>
							<p>
								<?= tohtml( _("Anti-Virus")) ?>:
								<span class="u-ml5 ml-[5px]">
									<?= tohtml($_SESSION["ANTIVIRUS_SYSTEM"]) ?>
								</span>
								<a href="/edit/server/<?= tohtml(rawurlencode($_SESSION["ANTIVIRUS_SYSTEM"])) ?>/" class="u-ml5 ml-[5px]">
									<i class="fas fa-pencil icon-orange text-amber-700"></i>
								</a>
							</p>
						<?php } ?>
						<?php if (!empty($_SESSION["ANTISPAM_SYSTEM"])) { ?>
							<p>
								<?= tohtml( _("Spam Filter")) ?>:
								<span class="u-ml5 ml-[5px]">
									<?= tohtml($_SESSION["ANTISPAM_SYSTEM"]) ?>
								</span>
								<a href="/edit/server/<?= tohtml(rawurlencode($_SESSION["ANTISPAM_SYSTEM"])) ?>/" class="u-ml5 ml-[5px]">
									<i class="fas fa-pencil icon-orange text-amber-700"></i>
								</a>
							</p>
						<?php } ?>
						<?php if ($_SESSION["WEBMAIL_SYSTEM"]) { ?>
							<div class="u-mt15 u-mb10 mt-[15px] mb-[10px]">
								<label for="v_webmail_alias" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Webmail Alias")) ?>
									<span x-cloak x-text="`${webmailAlias}.example.com`" class="hint text-sm leading-6 text-slate-500"></span>
								</label>
								<input
									x-model="webmailAlias"
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_webmail_alias"
									id="v_webmail_alias"
								>
							</div>
						<?php } ?>
						<div class="form-check u-mt20 flex items-center gap-2 mt-[20px]">
							<input
								x-model="hasSmtpRelay"
								class="form-check-input accent-blue-600"
								type="checkbox"
								name="v_smtp_relay"
								id="v_smtp_relay"
							>
							<label for="v_smtp_relay">
								<?= tohtml( _("Global SMTP Relay")) ?>
							</label>
						</div>
						<div
							x-cloak
							x-show="hasSmtpRelay"
							class="u-pl30 u-mt20 pl-[30px] mt-[20px]"
						>
							<div class="u-mb10 mb-[10px]">
								<label for="v_smtp_relay_host" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Host")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_smtp_relay_host"
									id="v_smtp_relay_host"
									value="<?= tohtml(trim($v_smtp_relay_host, "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_smtp_relay_port" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Port")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_smtp_relay_port"
									id="v_smtp_relay_port"
									value="<?= tohtml(trim($v_smtp_relay_port, "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_smtp_relay_user" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Username")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_smtp_relay_user"
									id="v_smtp_relay_user"
									value="<?= tohtml(trim($v_smtp_relay_user, "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_smtp_relay_pass" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Password")) ?>
								</label>
								<div class="u-pos-relative relative">
									<input
										type="text"
										class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
										name="v_smtp_relay_pass"
										id="v_smtp_relay_pass"
									>
								</div>
							</div>
						</div>
					</div>
				</details>
			<?php } ?>

			<!-- Databases section -->
			<?php if (!empty($_SESSION["DB_SYSTEM"])) { ?>
				<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
					<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
						<i class="fas fa-database u-mr10 mr-[10px]"></i><?= tohtml( _("Databases")) ?>
					</summary>
					<div class="box-collapse-content p-4">
						<div class="u-mb10 mb-[10px]">
							<p>
								<?= tohtml( _("MySQL Support")) ?>:
								<span class="u-ml5 ml-[5px]">
									<?= tohtml($v_mysql == "yes" ? _("Yes") : _("No")) ?>
								</span>
								<a href="/edit/server/mysql/" class="u-ml5 ml-[5px]">
									<i class="fas fa-pencil icon-orange text-amber-700"></i>
								</a>
							</p>
						</div>
						<!-- MySQL / MariaDB Options-->
						<?php if ($v_mysql == "yes") { ?>
							<div class="u-mb20 mb-[20px]">
								<label for="v_mysql_url" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("phpMyAdmin Alias")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_mysql_url"
									id="v_mysql_url"
										value="<?= tohtml($_SESSION["DB_PMA_ALIAS"]) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_phpmyadmin_key" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("phpMyAdmin Single Sign On")) ?>
									<span class="hint text-sm leading-6 text-slate-500">
										<a
											href="https://hestiacp.com/docs/server-administration/databases.html"
											target="_blank"
										>
											(<?= tohtml( _("More info")) ?>)
										</a>
									</span>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_phpmyadmin_key"
									id="v_phpmyadmin_key"
									<?php $_SESSION["API"] != "yes" ? "disabled" : ""; ?>
								>
									<option value="no">
										<?= tohtml( _("Disabled")) ?>
									</option>
									<option value="yes" <?= tohtml($_SESSION["PHPMYADMIN_KEY"] != "" ? "selected" : "") ?>>
										<?= tohtml( _("Enabled")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_pma_restrict" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Restrict phpMyAdmin to W3VJHOST login")) ?>
									<span class="hint text-sm leading-6 text-slate-500">
										<?= tohtml( _("Blocks phpMyAdmin's own login form; only reachable via the phpMyAdmin link inside W3VJHOST (requires SSO above).")) ?>
									</span>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_pma_restrict"
									id="v_pma_restrict"
									<?php echo $_SESSION["PHPMYADMIN_KEY"] == "" ? "disabled" : ""; ?>
								>
									<option value="no">
										<?= tohtml( _("Disabled")) ?>
									</option>
									<option value="yes" <?= tohtml($_SESSION["PMA_RESTRICT_ACCESS"] == "yes" ? "selected" : "") ?>>
										<?= tohtml( _("Enabled")) ?>
									</option>
								</select>
							</div>
							<?php
								$i = 0;
								foreach ($v_mysql_hosts as $value) {
									$i++;
							?>
							<div class="u-pl30 pl-[30px]">
								<div class="u-mb10 mb-[10px]">
									<label for="v_mysql_host" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Host") . " #" . $i) ?>
									</label>
									<input
										type="text"
										class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
										name="v_mysql_host"
										id="v_mysql_host"
										value="<?= tohtml($value["HOST"]) ?>"
										disabled
									>
								</div>
								<div class="u-mb10 mb-[10px]">
									<label for="v_mysql_password" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Password")) ?>
									</label>
									<div class="u-pos-relative relative">
										<input
											type="text"
											class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
											name="v_mysql_password"
											id="v_mysql_password"
										>
									</div>
								</div>
								<div class="u-mb10 mb-[10px]">
									<label for="v_mysql_max" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Maximum Number of Databases")) ?>
									</label>
									<input
										type="text"
										class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
										name="v_mysql_max"
										id="v_mysql_max"
										value="<?= tohtml($value["MAX_DB"]) ?>"
										disabled
									>
								</div>
								<div class="u-mb10 mb-[10px]">
									<label for="v_mysql_current" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Current Number of Databases")) ?>
									</label>
									<input
										type="text"
										class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
										name="v_mysql_current"
										id="v_mysql_current"
										value="<?= tohtml($value["U_DB_BASES"]) ?>"
										disabled
									>
								</div>
							</div>
						<?php } } ?>
						<!-- PostgreSQL Options-->
						<?php if ($v_pgsql == "yes") { ?>
							<div class="u-mb10 mb-[10px]">
								<p>
									<?= tohtml( _("PostgreSQL Support")) ?>:
									<span class="u-ml5 ml-[5px]">
										<?= tohtml($v_pgsql == "yes" ? _("Yes") : _("No")) ?>
									</span>
									<a href="/edit/server/postgresql/" class="u-ml5 ml-[5px]">
										<i class="fas fa-pencil icon-orange text-amber-700"></i>
									</a>
								</p>
							</div>
							<div class="u-mb20 mb-[20px]">
								<label for="v_pgsql_url" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("phpPgAdmin Alias")) ?>
								</label>
								<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_pgsql_url" id="v_pgsql_url" value="<?= tohtml($_SESSION["DB_PGA_ALIAS"]) ?>">
							</div>
						<?php } ?>
						<?php if ($v_pgsql == "yes") {
							$i = 0;
							foreach ($v_pgsql_hosts as $value) {
								$i++;
							?>
							<div class="u-pl30 pl-[30px]">
								<div class="u-mb10 mb-[10px]">
									<label for="v_pgsql_host" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Host") . " #" . $i) ?></label>
									<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_pgsql_host" id="v_pgsql_host" value="<?= tohtml($value["HOST"]) ?>" disabled>
								</div>
								<div class="u-mb10 mb-[10px]">
									<label for="v_psql_max" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Maximum Number of Databases")) ?>
									</label>
									<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_psql_max" id="v_psql_max" value="<?= tohtml($value["MAX_DB"]) ?>" disabled>
								</div>
								<div class="u-mb10 mb-[10px]">
									<label for="v_pgsql_max" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Current Number of Databases")) ?>
									</label>
									<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_pgsql_max" id="v_pgsql_max" value="<?= tohtml($value["U_DB_BASES"]) ?>" disabled>
								</div>
							</div>
						<?php }} ?>
					</div>
				</details>
			<?php } ?>

			<!-- Backups section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-arrow-rotate-left u-mr10 mr-[10px]"></i><?= tohtml( _("Backups")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_backup" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Local Backup")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_backup" id="v_backup">
							<option value="no">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="yes" <?= tohtml($v_backup == "yes" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_backup_mode" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Compression")) ?>
							<a
								href="https://hestiacp.com/docs/server-administration/backup-restore.html#what-is-the-difference-between-zstd-and-gzip"
								target="_blank"
								class="u-ml5 ml-[5px]"
							>
								<i class="fas fa-circle-question"></i>
							</a>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_backup_mode" id="v_backup_mode">
							<option value="gzip">
								gzip
							</option>
							<option value="zstd" <?= tohtml($v_backup_mode == "zstd" ? "selected" : "") ?>>
								zstd
							</option>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_backup_gzip" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Compression Level")) ?>
							<a
								href="https://hestiacp.com/docs/server-administration/backup-restore.html#what-is-the-optimal-compression-ratio"
								target="_blank"
								class="u-ml5 ml-[5px]"
							>
								<i class="fas fa-circle-question"></i>
							</a>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_backup_gzip" id="v_backup_gzip">
							<?php for ($level = 1; $level < 20; $level++) { ?>
								<option
									value="<?= tohtml($level) ?>"
									<?= tohtml($v_backup_gzip == $level ? "selected" : "") ?>
								>
									<?= tohtml($level) ?>
									<?= tohtml($level > 9 ? "(" . _("zstd only") . ")" : "") ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="u-mb20 mb-[20px]">
						<label for="v_backup_dir" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Directory")) ?>
							<a
								href="https://hestiacp.com/docs/server-administration/backup-restore.html#how-to-change-default-backup-folder"
								target="_blank"
								class="u-ml5 ml-[5px]"
							>
								<i class="fas fa-circle-question"></i>
							</a>
						</label>
						<input
							type="text"
							class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
							name="v_backup_dir"
							id="v_backup_dir"
							value="<?= tohtml(trim($v_backup_dir, "'")) ?>"
							disabled
						>
					</div>
					<div class="form-check flex items-center gap-2">
						<input
							x-model="remoteBackupEnabled"
							class="form-check-input accent-blue-600"
							type="checkbox"
							name="v_backup_remote_adv"
							id="v_backup_remote_adv"
						>
						<label for="v_backup_remote_adv">
							<?= tohtml( _("Remote Backup")) ?>
						</label>
					</div>
					<div x-cloak x-show="remoteBackupEnabled" class="u-pl30 u-mt20 pl-[30px] mt-[20px]">
						<div class="u-mb10 mb-[10px]">
							<label for="backup_type" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("Protocol")) ?>
								<a
									href="https://hestiacp.com/docs/server-administration/backup-restore.html#what-kind-of-protocols-are-currently-supported"
									target="_blank"
									class="u-ml5 ml-[5px]"
								>
									<i class="fas fa-circle-question"></i>
								</a>
							</label>
							<select
								x-model="backupType"
								class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
								name="v_backup_type"
								id="backup_type"
							>
								<option value="ftp">
									FTP
								</option>
								<option value="sftp">
									SFTP
								</option>
								<option value="b2">
									Backblaze
								</option>
								<option value="rclone">
									Rclone
								</option>
							</select>
						</div>
						<div x-cloak x-show="backupType == 'ftp' || backupType == 'sftp' || backupType == ''">
							<div class="u-mb10 mb-[10px]">
								<label for="v_backup_host" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Host")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_backup_host"
									id="v_backup_host"
									value="<?= tohtml(trim($v_backup_host, "'")) ?>"
								>
							</div>
							<div class="u-mb20 mb-[20px]">
								<label for="v_backup_port" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Port")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_backup_port"
									id="v_backup_port"
									value="<?= tohtml(trim($v_backup_port, "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_backup_username" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Username")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_backup_username"
									id="v_backup_username"
									value="<?= tohtml(trim($v_backup_username, "'")) ?>"
								>
							</div>
							<div class="u-mb20 mb-[20px]">
								<label for="v_backup_password" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Password")) ?>
								</label>
								<div class="u-pos-relative relative">
									<input
										type="text"
										class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
										name="v_backup_password"
										id="v_backup_password"
										value="<?= tohtml(trim($v_backup_password, "'")) ?>"
									>
								</div>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_backup_bpath" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Directory")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_backup_bpath"
									id="v_backup_bpath"
									value="<?= tohtml(trim($v_backup_bpath, "'")) ?>"
								>
							</div>
						</div>
						<div x-cloak x-show="backupType == 'b2'">
							<div class="u-mb10 mb-[10px]">
								<label for="v_backup_bucket" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									Bucket
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_backup_bucket"
									id="v_backup_bucket"
									value="<?= tohtml(trim($v_backup_bucket, "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_backup_application_id" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									Key ID
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_backup_application_id"
									id="v_backup_application_id"
									value="<?= tohtml(trim($v_backup_application_id, "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_backup_application_key" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									Application Key
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_backup_application_key"
									id="v_backup_application_key"
									value="<?= tohtml(trim($v_backup_application_key, "'")) ?>"
								>
							</div>
						</div>
						<div x-cloak x-show="backupType == 'rclone'">
							<div class="u-mb10 mb-[10px]">
								<label for="v_rclone_host" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Host")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_rclone_host"
									id="v_rclone_host"
									value="<?= tohtml(trim($v_rclone_host, "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_rclone_path" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Directory")) ?>
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_rclone_path"
									id="v_rclone_path"
									value="<?= tohtml(trim($v_rclone_path, "'")) ?>"
								>
							</div>
						</div>
					</div>
				</div>
			</details>
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-arrows-rotate u-mr10 mr-[10px]"></i><?= tohtml( _("Incremental Backups")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_backup_incremental" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Enable incremental backup")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_backup_incremental" id="v_backup_incremental" x-model="incrementalBackups">
							<option value="no">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="yes" <?= tohtml($v_backup_incremental == "yes" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
						<div x-cloak x-show="incrementalBackups == 'yes'">
						<div class="u-mb10 mb-[10px]">
							<label for="v_repo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("Repository")) ?>
							</label>
							<input
								type="text"
								class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
								name="v_repo"
								id="v_repo"
								value="<?= tohtml(trim($v_repo, "'")) ?>"
							>
						</div>
						<div class="u-mb10 mb-[10px]">
							<label for="v_repo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("Snapshots")) ?>
							</label>
							<input
								type="text"
								class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
								name="v_snapshots"
								id="v_snapshots"
								value="<?= tohtml(trim($v_snapshots, "'")) ?>"
							>
						</div>
						<div class="u-mb10 mb-[10px]">
							<label for="v_repo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("Keep last daily backups")) ?>
							</label>
							<input
								type="text"
								class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
								name="v_keep_daily"
								id="v_keep_daily"
								value="<?= tohtml(trim($v_keep_daily, "'")) ?>"
							>
						</div>
						<div class="u-mb10 mb-[10px]">
							<label for="v_repo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("Keep last weekly backups")) ?>
							</label>
							<input
								type="text"
								class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
								name="v_keep_weekly"
								id="v_keep_weekly"
								value="<?= tohtml(trim($v_keep_weekly, "'")) ?>"
							>
						</div>
						<div class="u-mb10 mb-[10px]">
							<label for="v_repo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("Keep last monthly backups")) ?>
							</label>
							<input
								type="text"
								class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
								name="v_keep_monthly"
								id="v_keep_monthly"
								value="<?= tohtml(trim($v_keep_monthly, "'")) ?>"
							>
						</div>
						<div class="u-mb10 mb-[10px]">
							<label for="v_repo" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml( _("Keep last yearly backups")) ?>
							</label>
							<input
								type="text"
								class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
								name="v_keep_yearly"
								id="v_keep_yearly"
								value="<?= tohtml(trim($v_keep_yearly, "'")) ?>"
							>
						</div>
					</div>
				</div>
			</details>

			<!-- SSL section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-lock u-mr10 mr-[10px]"></i><?= tohtml( _("SSL")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="u-mb20 mb-[20px]">
						<label for="v_ssl_crt" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("SSL Certificate")) ?>
							<span id="generate-csr">
								/
								<a
									class="form-link inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50"
									href="/generate/ssl/?<?= tohtml(http_build_query(["domain" => trim($v_hostname, '"')])) ?>"
									target="_blank"
								>
									<?= tohtml( _("Generate Self-Signed SSL Certificate")) ?>
								</a>
							</span>
						</label>
						<textarea
							class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight"
							name="v_ssl_crt"
							id="v_ssl_crt"
						><?= tohtml(trim($v_ssl_crt, "'")) ?></textarea>
					</div>
					<div class="u-mb20 mb-[20px]">
						<label for="v_ssl_key" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("SSL Private Key")) ?>
						</label>
						<textarea
							class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight"
							name="v_ssl_key"
							id="v_ssl_key"
						><?= tohtml(trim($v_ssl_key, "'")) ?></textarea>
					</div>
					<ul class="values-list">
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Issued To")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_subject) ?></span>
						</li>
						<?php if ($v_ssl_aliases) { ?>
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
				</div>
			</details>

			<!-- Security section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-key u-mr10 mr-[10px]"></i><?= tohtml( _("Security")) ?>
				</summary>
				<div class="box-collapse-content p-4">

					<details class="collapse">
						<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
							<?= tohtml( _("System")) ?>
						</summary>
						<div class="collapse-content pt-4">
							<h3 class="u-mb10 mb-[10px]">
								<?= tohtml( _("API")) ?>
							</h3>
							<div class="u-mb10 mb-[10px]">
								<label for="v_api_system" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Enable API access")) ?>
								</label>
								<select x-model="apiSystem" class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_api_system" id="v_api_system">
									<option value="0">
										<?= tohtml( _("Disabled")) ?>
									</option>
									<option value="1">
										<?= tohtml( _("Enabled for admin")) ?>
									</option>
									<option value="2">
										<?= tohtml( _("Enabled for all users")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_api" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Enable legacy API access")) ?>
								</label>
								<select x-model="legacyApi" class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_api" id="v_api">
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no">
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div x-cloak x-show="legacyApi === 'yes' || apiSystem > 0">
								<div class="u-mb10 mb-[10px]">
									<label for="v_api_allowed_ip" class="form-label u-side-by-side mb-1 block text-sm font-semibold text-slate-700 flex flex-wrap items-center gap-2">
										<?= tohtml( _("Allowed IP addresses for API")) ?>
										<span class="optional text-xs font-normal text-slate-500">1 IP address per line</span>
									</label>
									<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_api_allowed_ip" id="v_api_allowed_ip"><?php
											foreach (explode(",", $_SESSION["API_ALLOWED_IP"]) as $ip) {
												echo trim($ip)."\n";
											}
										?></textarea>
								</div>
							</div>
							<h3 class="u-mt20 u-mb10 mt-[20px] mb-[10px]">
								<?= tohtml( _("Login")) ?>
							</h3>
							<div class="u-mb10 mb-[10px]">
								<label for="v_login_style" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Login screen style")) ?>
								</label>
								<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_login_style" id="v_login_style">
									<option value="default">
										<?= tohtml( _("Default")) ?>
									</option>
									<option value="old" <?= tohtml($_SESSION["LOGIN_STYLE"] == "old" ? "selected" : "") ?>>
										<?= tohtml( _("Old Style")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_system_password_reset" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Allow users to reset their passwords")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_system_password_reset"
									id="v_policy_system_password_reset"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option
										value="no"
										<?= tohtml($_SESSION["POLICY_SYSTEM_PASSWORD_RESET"] == "no" ? "selected" : "") ?>
									>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb20 mb-[20px]">
								<label for="v_inactive_session_timeout" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Inactive session timeout")) ?> (<?= tohtml( _("Minutes")) ?>)
								</label>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="v_inactive_session_timeout"
									id="v_inactive_session_timeout"
									value="<?= tohtml(trim($_SESSION["INACTIVE_SESSION_TIMEOUT"], "'")) ?>"
								>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_csrf_strictness" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Prevent CSRF")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_csrf_strictness"
									id="v_policy_csrf_strictness"
								>
									<option value="0">
										<?= tohtml( _("Disabled")) ?>
									</option>
									<option value="1"	<?= tohtml($_SESSION["POLICY_CSRF_STRICTNESS"] == "1" ? "selected" : "") ?>>
										<?= tohtml( _("Enabled")) ?>
									</option>
									<option value="2"	<?= tohtml($_SESSION["POLICY_CSRF_STRICTNESS"] == "2" ? "selected" : "") ?>>
										<?= tohtml( _("Strict")) ?>
									</option>
								</select>
							</div>
						</div>
					</details>

					<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["user"] === $_SESSION["ROOT_USER"]) { ?>
						<details class="collapse">
							<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
								<?= tohtml( _("System Protection")) ?>
							</summary>
							<div class="collapse-content pt-4">
								<h3 class="u-mb10 mb-[10px]">
									<?= tohtml( _("System Administrator account")) ?>
								</h3>
								<div class="u-mb10 mb-[10px]">
									<label for="v_policy_system_protected_admin" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Restrict access to read-only for other administrators")) ?>
									</label>
									<select
										class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
										name="v_policy_system_protected_admin"
										id="v_policy_system_protected_admin"
									>
										<option value="yes">
											<?= tohtml( _("Yes")) ?>
										</option>
										<option value="no" <?= tohtml($_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] !== "yes" ? "selected" : "") ?>>
											<?= tohtml( _("No")) ?>
										</option>
									</select>
								</div>
								<div class="u-mb10 mb-[10px]">
									<label for="v_policy_system_hide_admin" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Hide account from other administrators")) ?>
									</label>
									<select
										class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
										name="v_policy_system_hide_admin"
										id="v_policy_system_hide_admin"
									>
										<option value="yes">
											<?= tohtml( _("Yes")) ?>
										</option>
										<option value="no" <?= tohtml($_SESSION["POLICY_SYSTEM_HIDE_ADMIN"] !== "yes" ? "selected" : "") ?>>
											<?= tohtml( _("No")) ?>
										</option>
									</select>
								</div>
								<div class="u-mb10 mb-[10px]">
									<label for="v_policy_system_hide_services" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Do not allow other administrators to access Server Settings")) ?>
									</label>
									<select
										class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
										name="v_policy_system_hide_services"
										id="v_policy_system_hide_services"
									>
										<option value="yes">
											<?= tohtml( _("Yes")) ?>
										</option>
										<option value="no" <?= tohtml($_SESSION["POLICY_SYSTEM_HIDE_SERVICES"] !== "yes" ? "selected" : "") ?>>
											<?= tohtml( _("No")) ?>
										</option>
									</select>
								</div>
							</div>
						</details>
					<?php } ?>

					<details class="collapse">
						<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
							<?= tohtml( _("Policies")) ?>
						</summary>
						<div class="collapse-content pt-4">
							<h3 class="u-mb10 mb-[10px]">
								<?= tohtml( _("Users")) ?>
							</h3>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_user_edit_details" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Allow users to edit their account details")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_user_edit_details"
									id="v_policy_user_edit_details"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_USER_EDIT_DETAILS"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_user_edit_web_templates" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Allow users to change templates when editing web domains")) ?>
								</label>
								<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_policy_user_edit_web_templates" id="v_policy_user_edit_web_templates">
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_USER_EDIT_WEB_TEMPLATES"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_user_edit_dns_templates" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Allow users to change templates when editing DNS zones")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_user_edit_dns_templates"
									id="v_policy_user_edit_dns_templates"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_USER_EDIT_DNS_TEMPLATES"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_user_view_logs" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Allow users to view action and login history logs")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_user_view_logs"
									id="v_policy_user_view_logs"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_USER_VIEW_LOGS"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_user_delete_logs" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Allow users to delete log history")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_user_delete_logs"
									id="v_policy_user_delete_logs"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_USER_DELETE_LOGS"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<?php if ($_SESSION["POLICY_SYSTEM_ENABLE_BACON"] === "true") { ?>
								<div class="u-mb10 mb-[10px]">
									<label for="v_policy_user_view_suspended" class="form-label mb-1 block text-sm font-semibold text-slate-700">
										<?= tohtml( _("Allow suspended users to log in with read-only access")) ?>
										<span class="hint text-sm leading-6 text-slate-500">(<?= tohtml( _("Preview")) ?>)</span>
									</label>
									<select
										class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
										name="v_policy_user_view_suspended"
										id="v_policy_user_view_suspended"
									>
										<option value="yes">
											<?= tohtml( _("Yes")) ?>
										</option>
										<option value="no" <?= tohtml($_SESSION["POLICY_USER_VIEW_SUSPENDED"] == "no" ? "selected" : "") ?>>
											<?= tohtml( _("No")) ?>
										</option>
									</select>
								</div>
							<?php } ?>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_backup_suspended_users" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Allow suspended users to create new backups")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_backup_suspended_users"
									id="v_policy_backup_suspended_users"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_BACKUP_SUSPENDED_USERS"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_sync_error_documents" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Sync Error document templates on user rebuild")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_sync_error_documents"
									id="v_policy_sync_error_documents"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_SYNC_ERROR_DOCUMENTS"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_policy_sync_skeleton" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Sync Skeleton templates")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_policy_sync_skeleton"
									id="v_policy_sync_skeleton"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["POLICY_SYNC_SKELETON"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
							<h3 class="u-mt20 u-mb10 mt-[20px] mb-[10px]">
								<?= tohtml( _("Domains")) ?>
							</h3>
							<div class="u-mb10 mb-[10px]">
								<label for="v_enforce_subdomain_ownership" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Enforce subdomain ownership")) ?>
								</label>
								<select
									class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
									name="v_enforce_subdomain_ownership"
									id="v_enforce_subdomain_ownership"
								>
									<option value="yes">
										<?= tohtml( _("Yes")) ?>
									</option>
									<option value="no" <?= tohtml($_SESSION["ENFORCE_SUBDOMAIN_OWNERSHIP"] == "no" ? "selected" : "") ?>>
										<?= tohtml( _("No")) ?>
									</option>
								</select>
							</div>
						</div>
					</details>

				</div>
			</details>

			<!-- Plugins section -->
			<details class="box-collapse u-mb10 rounded-lg border border-slate-200 bg-white mb-[10px]">
				<summary class="box-collapse-header cursor-pointer rounded-lg bg-slate-50 px-4 py-3 font-semibold text-blue-700">
					<i class="fas fa-puzzle-piece u-mr10 mr-[10px]"></i><?= tohtml( _("Plugins")) ?>
				</summary>
				<div class="box-collapse-content p-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_plugin_app_installer" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Quick App Installer")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_plugin_app_installer" id="v_plugin_app_installer">
							<option value="false">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="true" <?= tohtml($_SESSION["PLUGIN_APP_INSTALLER"] == "true" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_filemanager" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("File Manager")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_filemanager" id="v_filemanager">
							<option value="false">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="true" <?= tohtml($_SESSION["FILE_MANAGER"] == "true" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_web_terminal" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Web Terminal")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_web_terminal" id="v_web_terminal">
							<option value="false">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="true" <?= tohtml($_SESSION["WEB_TERMINAL"] == "true" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_resources_limit" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Limit System Resources")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_resources_limit" id="v_resources_limit">
							<option value="no">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="yes" <?= tohtml($_SESSION["RESOURCES_LIMIT"] == "yes" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_quota" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("File System Disk Quota")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_quota" id="v_quota">
							<option value="no">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="yes" <?= tohtml($_SESSION["DISK_QUOTA"] == "yes" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_firewall" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Firewall")) ?>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_firewall" id="v_firewall">
							<option value="no">
								<?= tohtml( _("No")) ?>
							</option>
							<option value="yes" <?= tohtml($_SESSION["FIREWALL_SYSTEM"] == "iptables" ? "selected" : "") ?>>
								<?= tohtml( _("Yes")) ?>
							</option>
						</select>
					</div>
				</div>
			</details>
		</div>
	</form>
</div>
<!-- End form -->
