<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["look"] == '') { ?>
				<a class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href='/list/stats/'><i class="fas fa-binoculars icon-lightblue text-sky-700"></i><?= tohtml( _("Overall Statistics")) ?></a>
			<?php } ?>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["look"] == '') { ?>
				<form x-data x-bind="BulkEdit" action="/list/stats/" method="get">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="user">
						<option value=""><?= tohtml( _("Show Per User")) ?></option>
						<?php
							foreach ($users as $key => $value) {
								if (($_SESSION['POLICY_SYSTEM_HIDE_ADMIN'] === 'yes') && ($value === $_SESSION['ROOT_USER'])) {
									// Hide admin user from statistics list
								} else {
								echo "\t\t\t\t<option value=\"".$value."\"";
								if ((!empty($v_user)) && ( $value == $_GET['user'])){
									echo ' selected';
								}
									echo ">".$value."</option>\n";
								}
							}
						?>
					</select>
					<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml( _("Apply to selected")) ?>">
						<i class="fas fa-arrow-right"></i>
					</button>
				</form>
			<?php } ?>
			<div class="toolbar-search min-w-0">
				<form action="/search/" method="get">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
					<input type="search" class="form-control js-search-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="q" value="<?= tohtml($_POST['q'] ?? '') ?>" title="<?= tohtml( _("Search")) ?>">
					<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml( _("Search")) ?>">
						<i class="fas fa-magnifying-glass"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<!-- Begin statistics list item loop -->
	<div class="stats">
		<?php foreach ($data as $key => $value) {
		++$i; ?>
			<div class="stats-item border-b border-slate-200 py-5">

				<div class="stats-item-header mb-4 flex items-center gap-3">
					<i class="fas fa-chart-bar icon-dim stats-item-header-icon u-mr10 text-slate-400 mr-[10px] text-2xl text-blue-700"></i>
					<h2 class="stats-item-header-title text-xl font-semibold">
						<?php $date = new DateTime($key);
						echo _($date -> format('M')) .' '.$date -> format('Y') ?>
					</h2>
				</div>

				<div class="stats-item-content grid gap-5 md:grid-cols-[1fr_2fr]">

					<div class="stats-item-summary">
						<h3 class="stats-item-summary-title mb-3 flex justify-between border-b border-slate-200 pb-2 font-semibold">
							<span class="u-text-bold font-bold">
								<i class="fas fa-right-left icon-dim icon-large u-mr5 text-slate-400 text-base mr-[5px]" title="<?= tohtml( _("Bandwidth")) ?>"></i>
								<?= tohtml( _("Bandwidth")) ?>
							</span>
							<span class="u-mr10 mr-[10px]">
								<span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["U_BANDWIDTH"])) ?></span>
								<?= tohtml(humanize_usage_measure($data[$key]["U_BANDWIDTH"])) ?> / <span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["BANDWIDTH"])) ?></span>
									<?= tohtml(humanize_usage_measure($data[$key]["BANDWIDTH"])) ?>
							</span>
						</h3>
						<ul class="stats-item-summary-list u-mb10 mb-[10px]">
							<li class="stats-item-summary-list-item flex justify-between py-1">
								<span>
									<?php if ($_SESSION["userContext"] === "admin" || ($_SESSION["userContext"] === "user" && $data[$key]["IP_OWNED"] != "0")) { ?>
										<?= tohtml( _("IP Addresses")) ?>:
									<?php } ?>
								</span>
								<span>
									<span class="u-text-bold font-bold"><?= tohtml($data[$key]["IP_OWNED"]) ?></span>
									<?= tohtml( _("IPs")) ?>
								</span>
							</li>
						</ul>
						<h3 class="stats-item-summary-title mb-3 flex justify-between border-b border-slate-200 pb-2 font-semibold">
							<span class="u-text-bold font-bold">
								<i class="fas fa-hard-drive icon-dim icon-large u-mr5 text-slate-400 text-base mr-[5px]" title="Disk"></i>
								<?= tohtml( _("Disk")) ?>
							</span>
							<span class="u-mr10 mr-[10px]">
								<span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["U_DISK"])) ?></span>
								<?= tohtml(humanize_usage_measure($data[$key]["U_DISK"])) ?> / <span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["DISK_QUOTA"])) ?></span>
										<?= tohtml(humanize_usage_measure($data[$key]["DISK_QUOTA"])) ?>
								</span>
							</span>
						</h3>
						<ul class="stats-item-summary-list">
							<li class="stats-item-summary-list-item flex justify-between py-1">
								<span>
									<?= tohtml( _("Web")) ?>:
								</span>
								<span>
									<span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["U_DISK_WEB"])) ?></span>
									<?= tohtml(humanize_usage_measure($data[$key]["U_DISK_WEB"])) ?>
								</span>
							</li>
							<li class="stats-item-summary-list-item u-mb5 mb-[5px] flex justify-between py-1">
								<span>
									<?= tohtml( _("Databases")) ?>:
								</span>
								<span>
									<span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["U_DISK_DB"])) ?></span>
									<?= tohtml(humanize_usage_measure($data[$key]["U_DISK_DB"])) ?>
								</span>
							</li>
							<li class="stats-item-summary-list-item flex justify-between py-1">
								<span>
									<?= tohtml( _("Mail")) ?>:
								</span>
								<span>
									<span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["U_DISK_MAIL"])) ?></span>
									<?= tohtml(humanize_usage_measure($data[$key]["U_DISK_MAIL"])) ?>
								</span>
							</li>
							<li class="stats-item-summary-list-item flex justify-between py-1">
								<span>
									<?= tohtml( _("User Directory")) ?>:
								</span>
								<span>
									<span class="u-text-bold font-bold"><?= tohtml(humanize_usage_size($data[$key]["U_DISK_DIRS"])) ?></span>
									<?= tohtml(humanize_usage_measure($data[$key]["U_DISK_DIRS"])) ?>
								</span>
							</li>
						</ul>
					</div>

					<ul class="stats-item-list grid gap-3 sm:grid-cols-2">
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("Web Domains")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_WEB_DOMAINS"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("Mail Domains")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_MAIL_DOMAINS"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("SSL Domains")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_WEB_SSL"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("Mail Accounts")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_MAIL_ACCOUNTS"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("Web Aliases")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_WEB_ALIASES"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("Databases")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_DATABASES"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("DNS Zones")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_DNS_DOMAINS"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("Cron Jobs")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_CRON_JOBS"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("DNS Records")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_DNS_RECORDS"]) ?>
							</span>
						</li>
						<li class="stats-item-list-item flex justify-between gap-4">
							<span class="stats-item-list-item-label text-slate-500">
								<?= tohtml( _("Backups")) ?>:
							</span>
							<span class="stats-item-list-item-value font-semibold tabular-nums">
								<?= tohtml($data[$key]["U_BACKUPS"]) ?>
							</span>
						</li>
					</ul>

				</div>

			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d month", "%d months", $i), $i); ?>
		</p>
	</div>

</div>
