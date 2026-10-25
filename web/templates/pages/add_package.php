<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/package/">
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
		id="main-form"
		name="v_add_package"
		method="post"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add Package")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_package" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Package Name")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_package" id="v_package" value="<?= tohtml(trim($v_package, "'")) ?>" required>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_disk_quota" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Quota")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("in MB")) ?>)</span>
				</label>
				<div class="u-pos-relative relative">
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_disk_quota" id="v_disk_quota" value="<?= tohtml(trim($v_disk_quota, "'")) ?>">
					<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
						<i class="fas fa-infinity"></i>
					</button>
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_bandwidth" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Bandwidth")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("in MB")) ?>)</span>
				</label>
				<div class="u-pos-relative relative">
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_bandwidth" id="v_bandwidth" value="<?= tohtml(trim($v_bandwidth, "'")) ?>">
					<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
						<i class="fas fa-infinity"></i>
					</button>
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_backups" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Backups")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_backups" id="v_backups" value="<?= tohtml(trim($v_backups, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_backups_incremental" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Incremental Backups")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_backups_incremental" id="v_backups_incremental">
						<option value="no"><?= tohtml( _("Disabled")) ?></option>
						<option value="yes" <?php if ('yes' == trim($v_backups_incremental, "''")): ?>
							selected
						<?php endif; ?>><?= tohtml( _("Enabled")) ?></option>
				</select>
			</div>
			<details class="collapse" id="web-options">
				<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
					<?= tohtml( _("WEB")) ?>
				</summary>
				<div class="collapse-content pt-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_web_domains" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Web Domains")) ?></label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_web_domains" id="v_web_domains" value="<?= tohtml(trim($v_web_domains, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_web_aliases" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Web Aliases")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("per domain")) ?>)</span>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_web_aliases" id="v_web_aliases" value="<?= tohtml(trim($v_web_aliases, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_web_template" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Web Template")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["WEB_SYSTEM"])) ?></span>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_web_template" id="v_web_template">
								<?php
									foreach ($web_templates as $key => $value) {
										echo "\t\t\t\t<option value=\"" . tohtml($value) . "\"";
										if ((!empty($v_web_template)) && ( $value == trim($v_web_template, "'"))){
											echo ' selected' ;
										}
										echo ">" . tohtml($value) . "</option>\n";
									}
								?>
						</select>
					</div>
					<?php if (!empty($_SESSION['WEB_BACKEND'])) { echo ""; ?>
						<div class="u-mb10 mb-[10px]">
								<label for="v_backend_template" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Backend Template")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["WEB_BACKEND"])) ?></span>
								</label>
							<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_backend_template" id="v_backend_template">
									<?php
										foreach ($backend_templates as $key => $value) {
											echo "\t\t\t\t<option value=\"" . tohtml($value) . "\"";
											if ((!empty($v_backend_template)) && ( $value == trim($v_backend_template, "'"))){
												echo ' selected' ;
											}
											echo ">" . tohtml($value) . "</option>\n";
										}
									?>
							</select>
						</div>
						<?php } ?>
					<?php if (!empty($_SESSION['PROXY_SYSTEM'])) { echo ""; ?>
						<div class="u-mb10 mb-[10px]">
								<label for="v_proxy_template" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Proxy Template")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["PROXY_SYSTEM"])) ?></span>
								</label>
							<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_proxy_template" id="v_proxy_template">
								<?php
									foreach ($proxy_templates as $key => $value) {
										echo "\t\t\t\t<option value=\"" . tohtml($value) . "\"";
										if ((!empty($v_proxy_template)) && ( $value == trim($v_proxy_template, "'"))){
											echo ' selected' ;
										}
										echo ">" . tohtml($value) . "</option>\n";
									}
								?>
							</select>
						</div>
						<?php } ?>
				</div>
			</details>
			<details class="collapse" id="dns-options">
				<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
					<?= tohtml( _("DNS")) ?>
				</summary>
				<div class="collapse-content pt-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_dns_template" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("DNS Template")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["DNS_SYSTEM"])) ?></span>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_dns_template" id="v_dns_template">
								<?php
									foreach ($dns_templates as $key => $value) {
										echo "\t\t\t\t<option value=\"" . tohtml($value) . "\"";
										if ((!empty($v_dns_template)) && ( $value == trim($v_dns_template, "'"))){
											echo ' selected' ;
										}
										echo ">" . tohtml($value) . "</option>\n";
									}
								?>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_dns_domains" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("DNS Zones")) ?></label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_dns_domains" id="v_dns_domains" value="<?= tohtml(trim($v_dns_domains, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_dns_records" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("DNS Records")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("per domain")) ?>)</span>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_dns_records" id="v_dns_records" value="<?= tohtml(trim($v_dns_records, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<?php if (isset($_SESSION["DNS_SYSTEM"]) && !empty($_SESSION["DNS_SYSTEM"])) { ?>
						<p class="form-label u-mb10 mb-1 block text-sm font-semibold text-slate-700 mb-[10px]"><?= tohtml( _("Name Servers")) ?></p>
						<div class="u-mb5 mb-[5px]">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ns1" value="<?= tohtml(trim($v_ns1, "'")) ?>">
						</div>
						<div class="u-mb5 mb-[5px]">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ns2" value="<?= tohtml(trim($v_ns2, "'")) ?>">
						</div>
						<?php require $_SERVER["HESTIA"] . "/web/templates/includes/extra-ns-fields.php"; ?>
						<button type="button" data-remove-label="<?= tohtml(_("Remove")) ?>" class="form-link u-mt20 js-add-ns inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50 mt-[20px]" <?php if ($v_ns8) echo 'style="display:none;"'; ?>>
							<?= tohtml( _("Add Name Server")) ?>
						</button>
					<?php } ?>
				</div>
			</details>
			<details class="collapse" id="mail-options">
				<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
					<?= tohtml( _("MAIL")) ?>
				</summary>
				<div class="collapse-content pt-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_mail_domains" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Mail Domains")) ?></label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_mail_domains" id="v_mail_domains" value="<?= tohtml(trim($v_mail_domains, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_mail_accounts" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Mail Accounts")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("per domain")) ?>)</span>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_mail_accounts" id="v_mail_accounts" value="<?= tohtml(trim($v_mail_accounts, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_ratelimit" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Rate Limit")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("per account / hour")) ?>)</span>
						</label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ratelimit" id="v_ratelimit" value="<?= tohtml(trim($v_ratelimit, "'")) ?>">
					</div>
				</div>
			</details>
			<details class="collapse" id="database-options">
				<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
					<?= tohtml( _("DB")) ?>
				</summary>
				<div class="collapse-content pt-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_databases" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Databases")) ?></label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_databases" id="v_databases" value="<?= tohtml(trim($v_databases, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
				</div>
			</details>
			<details class="collapse" id="system-options">
				<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
					<?= tohtml( _("System")) ?>
				</summary>
				<div class="collapse-content pt-4">
					<div class="u-mb10 mb-[10px]">
						<label for="v_cron_jobs" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Cron Jobs")) ?></label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_cron_jobs" id="v_cron_jobs" value="<?= tohtml(trim($v_cron_jobs, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_shell" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("SSH Access")) ?></label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_shell" id="v_shell">
							<?php foreach ($shells as $key => $value): ?>
								<option value="<?= tohtml($value) ?>"
									<?php if (!empty($v_shell) && $value == trim($v_shell, "''")): ?>
										selected
									<?php endif; ?>
								>
									<?= tohtml($value) ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</details>

			<?php if ($_SESSION['RESOURCES_LIMIT'] == 'yes') { ?>
				<details class="collapse" id="system-resources-options">
				<summary class="collapse-header flex cursor-pointer items-center justify-between border-b border-slate-200 py-3 font-semibold">
					<?= tohtml( _("System Resources")) ?>
				</summary>
				<div class="collapse-content pt-4">
					<div class="u-mb10 mb-[10px]">
						<label for="cfs_quota" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("CPU Quota (in %)")) ?>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_cpu_quota" id="v_cpu_quota" value="<?= tohtml(trim($v_cpu_quota, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
						<small class="form-text text-muted text-sm text-slate-500"><?= tohtml( _("CPUQuota=20% ensures that the executed processes will never get more than 20% CPU time on one CPU.")) ?></small>
					</div>

					<div class="u-mb10 mb-[10px]">
						<label for="cfs_period" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("CPU Quota Period (in ms for milliseconds or s for seconds.)")) ?>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_cpu_quota_period" id="v_cpu_quota_period" value="<?= tohtml(trim($v_cpu_quota_period, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
						<small class="form-text text-muted text-sm text-slate-500"><?= tohtml( _("CPUQuotaPeriodSec=10ms to request that the CPU quota is measured in periods of 10ms.")) ?></small>
					</div>

					<div class="u-mb10 mb-[10px]">
						<label for="memory_limit" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Memory Limit (in bytes or with units like '2G')")) ?>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_memory_limit" id="v_memory_limit" value="<?= tohtml(trim($v_memory_limit, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
						<small class="form-text text-muted text-sm text-slate-500"><?= tohtml( _("Takes a memory size in bytes. If the value is suffixed with K, M, G or T, the specified memory size is parsed as Kilobytes, Megabytes, Gigabytes, or Terabytes (with the base 1024), respectively")) ?></small>
					</div>

					<div class="u-mb10 mb-[10px]">
						<label for="swap_limit" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Swap Limit (in bytes or with units like '2G')")) ?>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_swap_limit" id="v_swap_limit" value="<?= tohtml(trim($v_swap_limit, "'")) ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
						<small class="form-text text-muted text-sm text-slate-500"><?= tohtml( _("Takes a swap size in bytes. If the value is suffixed with K, M, G or T, the specified swap size is parsed as Kilobytes, Megabytes, Gigabytes, or Terabytes (with the base 1024), respectively")) ?></small>
					</div>
				</div>
			</details>
			<?php } ?>
		</div>

	</form>

</div>
