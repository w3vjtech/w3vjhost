<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true) { ?>
				<a href="/add/web/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Add Web Domain")) ?>
				</a>
			<?php } ?>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<div class="toolbar-sorting relative flex min-w-0 flex-wrap items-center gap-2 text-sm">
				<button class="toolbar-sorting-toggle js-toggle-sorting-menu rounded px-2 py-1 text-slate-600 hover:bg-slate-100" type="button" title="<?= tohtml( _("Sort items")) ?>">
					<?= tohtml( _("Sort by")) ?>:
					<span class="u-text-bold font-bold">
							<?php if ($_SESSION['userSortOrder'] === 'name') { $label = _('Name'); } else { $label = _('Date'); } ?>
						<?= tohtml($label) ?> <i class="fas fa-arrow-down-a-z"></i>
					</span>
				</button>
				<ul class="toolbar-sorting-menu js-sorting-menu u-hidden absolute top-full left-0 z-30 min-w-48 rounded-lg border border-slate-200 bg-white p-2 shadow-lg [&_li]:flex [&_span]:cursor-pointer [&_span]:p-2 [&_.active]:bg-blue-50">
					<li data-entity="sort-bandwidth" data-sort-as-int="1">
						<span class="name"><?= tohtml( _("Bandwidth")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-date" data-sort-as-int="1">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'date') { echo 'active'; } ?>"><?= tohtml( _("Date")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-disk" data-sort-as-int="1">
						<span class="name"><?= tohtml( _("Disk")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-name">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'name') { echo 'active'; } ?>"><?= tohtml( _("Name")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-ip" data-sort-as-int="1">
						<span class="name"><?= tohtml( _("IP Address")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<?php if ($read_only !== true) { ?>
					<form x-data x-bind="BulkEdit" action="/bulk/web/" method="post">
						<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
							<option value=""><?= tohtml( _("Apply to selected")) ?></option>
							<?php if ($_SESSION["userContext"] === "admin") { ?>
								<option value="rebuild"><?= tohtml( _("Rebuild")) ?></option>
							<?php } ?>
							<option value="suspend"><?= tohtml( _("Suspend")) ?></option>
							<option value="unsuspend"><?= tohtml( _("Unsuspend")) ?></option>
							<?php if ($_SESSION["PROXY_SYSTEM"] == "nginx" || $_SESSION["WEB_SYSTEM"] == "nginx") { ?>
								<option value="purge"><?= tohtml( _("Purge Nginx Cache")) ?></option>
							<?php } ?>
							<option value="delete"><?= tohtml( _("Delete")) ?></option>
						</select>
						<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml( _("Apply to selected")) ?>">
							<i class="fas fa-arrow-right"></i>
						</button>
					</form>
				<?php } ?>
			</div>
			<div class="toolbar-search min-w-0">
				<form action="/search/" method="get">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
					<input type="search" class="form-control js-search-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="q" value="<?= tohtml($_GET['q'] ?? '') ?>" title="<?= tohtml( _("Search")) ?>">
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

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Web Domains")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>"<?= $display_mode === "disabled" ? " disabled" : "" ?>>
				</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Name")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("IP Address")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Disk")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Bandwidth")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("SSL")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Statistics")) ?></div>
		</div>

		<!-- Begin web domain list item loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;
				if ($data[$key]['SUSPENDED'] == 'yes') {
					$status = 'suspended';
					$spnd_action = 'unsuspend';
					$spnd_action_title = _('Unsuspend');
					$spnd_icon = 'fa-play';
					$spnd_icon_class = 'icon-green text-green-700';
					$spnd_confirmation = _('Are you sure you want to unsuspend domain %s?');
				} else {
					$status = 'active';
					$spnd_action = 'suspend';
					$spnd_action_title = _('Suspend');
					$spnd_icon = 'fa-pause';
					$spnd_icon_class = 'icon-highlight text-slate-700';
					$spnd_confirmation = _('Are you sure you want to suspend domain %s?');
				}
				if (!empty($data[$key]['SSL_HOME'])) {
					if ($data[$key]['SSL_HOME'] == 'same') {
						$ssl_home = 'public_html';
					} else {
						$ssl_home = 'public_shtml';
					}
				} else {
					$ssl_home = '';
				}
				$web_stats='no';
				if (!empty($data[$key]['STATS'])) {
					$web_stats=$data[$key]['STATS'];
				}
				$ftp_user='no';
				if (!empty($data[$key]['FTP_USER'])) {
					$ftp_user=$data[$key]['FTP_USER'];
				}
				if (strlen($ftp_user) > 24 ) {
					$ftp_user = str_replace(':', ', ', $ftp_user);
					$ftp_user = substr($ftp_user, 0, 24);
					$ftp_user = trim($ftp_user, ":");
					$ftp_user = str_replace(':', ', ', $ftp_user);
					$ftp_user = $ftp_user.", ...";
				} else {
					$ftp_user = str_replace(':', ', ', $ftp_user);
				}

				$backend_support='no';
				if (!empty($data[$key]['BACKEND'])) {
					$backend_support='yes';
				}

				$proxy_support='no';
				if (!empty($data[$key]['PROXY'])) {
					$proxy_support='yes';
				}
				if (strlen($data[$key]['PROXY_EXT']) > 24 ) {
					$proxy_ext_title = str_replace(',', ', ', $data[$key]['PROXY_EXT']);
					$proxy_ext = substr($data[$key]['PROXY_EXT'], 0, 24);
					$proxy_ext = trim($proxy_ext, ",");
					$proxy_ext = str_replace(',', ', ', $proxy_ext);
					$proxy_ext = $proxy_ext.", ...";
				} else {
					$proxy_ext_title = '';
					$proxy_ext = str_replace(',', ', ', $data[$key]['PROXY_EXT']);
				}
				if ($data[$key]['SUSPENDED'] === 'yes') {
					if ($data[$key]['SSL'] == 'no') {
						$icon_ssl = 'fas fa-circle-xmark';
						$title_ssl = _('Disabled');
					}
					if ($data[$key]['SSL'] == 'yes') {
						$icon_ssl = 'fas fa-circle-check';
						$title_ssl = _('Enabled');
					}
					if ($web_stats == 'no') {
						$icon_webstats = 'fas fa-circle-xmark';
						$title_webstats = _('Disabled');
					} else {
						$icon_webstats = 'fas fa-circle-check';
						$title_webstats = _('Enabled');
					}
				} else {
					if ($data[$key]['SSL'] == 'no') {
						$icon_ssl = 'fas fa-circle-xmark icon-red text-red-700';
						$title_ssl = _('Disabled');
					}
					if ($data[$key]['SSL'] == 'yes') {
						$icon_ssl = 'fas fa-circle-check icon-green text-green-700';
						$title_ssl = _('Enabled');
					}
					if ($web_stats == 'no') {
						$icon_webstats = 'fas fa-circle-xmark icon-red text-red-700';
						$title_webstats = _('Disabled');
					} else {
						$icon_webstats = 'fas fa-circle-check icon-green text-green-700';
						$title_webstats = _('Enabled');
					}
				}
				$has_ssl = filter_var($data[$key]['SSL'], FILTER_VALIDATE_BOOL);
				$vstats_scheme = $has_ssl ? 'https' : 'http';
			?>
			<div class="units-table-row <?php if ($data[$key]['SUSPENDED'] == 'yes') echo 'disabled'; ?> js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-sort-ip="<?= tohtml(str_replace(".", "", $data[$key]["IP"])) ?>"
				data-sort-date="<?= tohtml(strtotime($data[$key]["DATE"] . " " . $data[$key]["TIME"])) ?>"
				data-sort-name="<?= tohtml($key) ?>"
				data-sort-bandwidth="<?= tohtml($data[$key]["U_BANDWIDTH"]) ?>"
				data-sort-disk="<?= tohtml($data[$key]["U_DISK"]) ?>">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml( _("Select")) ?>" name="domain[]" value="<?= tohtml($key) ?>"<?= $display_mode === "disabled" ? " disabled" : "" ?>>
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
					</div>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Name")) ?>:</span>
					<?php if ($read_only === true) { ?>
						<?= tohtml($key) ?>
					<?php } else {
						$aliases = explode(',', $data[$key]['ALIAS']);
						$alias_new = array();
						foreach($aliases as $alias){
							if ($alias != 'www.'.$key) {
								$alias_new[] = trim($alias);
							}
						}
						?>
						<a href="/edit/web/?<?= tohtml(http_build_query(["domain" => $key, "token" => $_SESSION['token']])) ?>" title="<?= tohtml( _("Edit Domain")) ?>: <?= tohtml($key) ?>">
							<?= tohtml($key) ?>
								<?php
									if (!empty($alias_new) && !empty($data[$key]['ALIAS'])) {
										$aliases = implode(', ', $alias_new);
										echo "<p class='hint u-max-width300 u-text-truncate'>(" . tohtml($aliases) . ")</p>";
									}
								?>
							</a>
						<?php } ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<?php if (!empty($data[$key]["STATS"])) { ?>
							<li class="units-table-row-action shortcut-w shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="<?= tohtml($vstats_scheme) ?>://<?= tohtml($key) ?>/vstats/"
									target="_blank"
									rel="noopener"
									title="<?= tohtml( _("Statistics")) ?>"
								>
									<i class="fas fa-chart-bar icon-maroon text-pink-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Statistics")) ?></span>
								</a>
							</li>
						<?php } ?>
						<li class="units-table-row-action shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="http://<?= tohtml($key) ?>/"
								target="_blank"
								rel="noopener"
								title="<?= tohtml( _("Visit")) ?>"
							>
								<i class="fas fa-square-up-right icon-lightblue text-sky-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Visit")) ?></span>
							</a>
						</li>
						<?php if ($read_only !== true) { ?>
							<?php if ($data[$key]["SUSPENDED"] == "no") { ?>
								<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
									<a
										class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
										href="/edit/web/?<?= tohtml(http_build_query(["domain" => $key, "token" => $_SESSION["token"]])) ?>"
										title="<?= tohtml( _("Edit Domain")) ?>"
									>
										<i class="fas fa-pencil icon-orange text-amber-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit Domain")) ?></span>
									</a>
								</li>
								<li class="units-table-row-action shrink-0" data-key-action="href">
									<a
										class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
										href="/download/site/?<?= tohtml(http_build_query(["site" => $key, "token" => $_SESSION["token"]])) ?>"
										title="<?= tohtml( _("Download Site")) ?>"
									>
										<i class="fas fa-download icon-orange text-amber-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Download Site")) ?></span>
									</a>
								</li>
							<?php } ?>
							<li class="units-table-row-action shortcut-l shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/list/web-log/?<?= tohtml(http_build_query(["domain" => $key, "type" => "access"])) ?>#"
									title="<?= tohtml( _("View Logs")) ?>"
								>
									<i class="fas fa-binoculars icon-purple text-purple-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("View Logs")) ?></span>
								</a>
							</li>
							<li class="units-table-row-action shortcut-s shrink-0" data-key-action="js">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/<?= tohtml($spnd_action) ?>/web/?<?= tohtml(http_build_query(["domain" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml($spnd_action_title) ?>"
									data-confirm-title="<?= tohtml($spnd_action_title) ?>"
									data-confirm-message="<?= tohtml(sprintf($spnd_confirmation, $key)) ?>"
								>
									<i class="fas <?= tohtml($spnd_icon) ?> <?= tohtml($spnd_icon_class) ?>"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml($spnd_action_title) ?></span>
								</a>
							</li>
							<li class="units-table-row-action shortcut-delete shrink-0" data-key-action="js">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/delete/web/?<?= tohtml(http_build_query(["domain" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Delete")) ?>"
									data-confirm-title="<?= tohtml( _("Delete")) ?>"
									data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to delete domain %s?"), $key)) ?>"
								>
									<i class="fas fa-trash icon-red text-red-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Delete")) ?></span>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IP Address")) ?>:</span>
					<?= tohtml(empty($ips[$data[$key]["IP"]]["NAT"]) ? $data[$key]["IP"] : "{$ips[$data[$key]["IP"]]["NAT"]}") ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Disk")) ?>:</span>
					<span class="u-text-bold font-bold">
						<?= tohtml(humanize_usage_size($data[$key]["U_DISK"])) ?>
					</span>
					<span class="u-text-small text-xs">
						<?= tohtml(humanize_usage_measure($data[$key]["U_DISK"])) ?>
					</span>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Bandwidth")) ?>:</span>
					<span class="u-text-bold font-bold">
						<?= tohtml(humanize_usage_size($data[$key]["U_BANDWIDTH"])) ?>
					</span>
					<span class="u-text-small text-xs">
						<?= tohtml(humanize_usage_measure($data[$key]["U_BANDWIDTH"])) ?>
					</span>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("SSL")) ?>:</span>
					<i class="fas <?= tohtml($icon_ssl) ?>" title="<?= tohtml($title_ssl) ?>"></i>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Statistics")) ?>:</span>
					<i class="fas <?= tohtml($icon_webstats) ?>" title="<?= tohtml($title_webstats) ?>"></i>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d web domain", "%d web domains", $i), $i); ?>
		</p>
	</div>

</div>
