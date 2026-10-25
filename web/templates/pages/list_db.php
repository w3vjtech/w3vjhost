<?php
[$http_host, $port] = explode(":", $_SERVER["HTTP_HOST"] . ":");
$db_myadmin_link = "//" . $http_host . "/phpmyadmin/";
$db_pgadmin_link = "//" . $http_host . "/phppgadmin/";

if (!empty($_SESSION["DB_PMA_ALIAS"])) {
	$db_myadmin_link = "//" . $http_host . "/" . $_SESSION["DB_PMA_ALIAS"] . "/";
}
if (!empty($_SESSION["DB_PGA_ALIAS"])) {
	$db_pgadmin_link = "//" . $http_host . "/" . $_SESSION["DB_PGA_ALIAS"] . "/";
}
?>

<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true) { ?>
				<a href="/add/db/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Add Database")) ?>
				</a>
				<?php if (!empty($nosql_data["services"]["mongodb"]) || !empty($nosql_data["services"]["redis"])) { ?>
					<a href="/add/nosql/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
						<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml(_("Add NoSQL Database")) ?>
					</a>
				<?php } ?>
				<?php if ($_SESSION["DB_SYSTEM"] === "mysql" || $_SESSION["DB_SYSTEM"] === "mysql,pgsql" || $_SESSION["DB_SYSTEM"] === "pgsql,mysql") { ?>
					<a class="button button-secondary <?= tohtml(ipUsed() ? "button-suspended" : "") ?> inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="<?= tohtml($db_myadmin_link) ?>" target="_blank">
						<i class="fas fa-database icon-orange text-amber-700"></i>phpMyAdmin
					</a>
				<?php } ?>
				<?php if ($_SESSION["DB_SYSTEM"] === "pgsql" || $_SESSION["DB_SYSTEM"] === "mysql,pgsql" || $_SESSION["DB_SYSTEM"] === "pgsql,mysql") { ?>
					<a class="button button-secondary <?= tohtml(ipUsed() ? "button-suspended" : "") ?> inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="<?= tohtml($db_pgadmin_link) ?>" target="_blank">
						<i class="fas fa-database icon-orange text-amber-700"></i>phpPgAdmin
					</a>
				<?php } ?>
				<?php if (ipUsed()) { ?>
					<a target="_blank" href="https://hestiacp.com/docs/server-administration/databases.html#why-i-can-t-use-http-ip-phpmyadmin">
						<i class="fas fa-circle-question"></i>
					</a>
				<?php } ?>
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
					<li data-entity="sort-charset">
						<span class="name"><?= tohtml( _("Charset")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
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
					<li data-entity="sort-server">
						<span class="name"><?= tohtml( _("Host")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-user">
						<span class="name"><?= tohtml( _("Username")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<?php if ($read_only !== true) { ?>
					<form x-data x-bind="BulkEdit" action="/bulk/db/" method="post">
						<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
							<option value=""><?= tohtml( _("Apply to selected")) ?></option>
							<?php if ($_SESSION["userContext"] === "admin") { ?>
								<option value="rebuild"><?= tohtml( _("Rebuild All")) ?></option>
								<option value="suspend"><?= tohtml( _("Suspend All")) ?></option>
								<option value="unsuspend"><?= tohtml( _("Unsuspend All")) ?></option>
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

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Databases")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>" <?= tohtml($display_mode) ?>>
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Name")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Disk")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Type")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Username")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Hostname")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Charset")) ?></div>
		</div>

		<!-- Begin database list item loop -->
		<?php
			list($http_host, $port) = explode(':', $_SERVER["HTTP_HOST"].":");
			foreach ($data as $key => $value) {
				++$i;
				if ($data[$key]['SUSPENDED'] == 'yes') {
					$status = 'suspended';
					$spnd_action = 'unsuspend';
					$spnd_action_title = _('Unsuspend');
					$spnd_icon = 'fa-play';
					$spnd_icon_class = 'icon-green text-green-700';
					$spnd_confirmation = _('Are you sure you want to unsuspend database %s?') ;
				} else {
					$status = 'active';
					$spnd_action = 'suspend';
					$spnd_action_title = _('Suspend');
					$spnd_icon = 'fa-pause';
					$spnd_icon_class = 'icon-highlight text-slate-700';
					$spnd_confirmation = _('Are you sure you want to suspend database %s?') ;
				}
				if ($data[$key]['HOST'] != 'localhost' ) $http_host = $data[$key]['HOST'];
				if ($data[$key]['TYPE'] == 'mysql') $db_admin = "phpMyAdmin";
				if ($data[$key]['TYPE'] == 'mysql') $db_admin_link = "https://".$http_host."/phpmyadmin/";
				if (($data[$key]['TYPE'] == 'mysql') && (!empty($_SESSION['DB_PMA_ALIAS']))) $db_admin_link = $_SESSION['DB_PMA_ALIAS'];
				if ($data[$key]['TYPE'] == 'pgsql') $db_admin = "phpPgAdmin";
				if ($data[$key]['TYPE'] == 'pgsql') $db_admin_link = "https://".$http_host."/phppgadmin/";
				if (($data[$key]['TYPE'] == 'pgsql') && (!empty($_SESSION['DB_PGA_ALIAS']))) $db_admin_link = $_SESSION['DB_PGA_ALIAS'];
			?>
			<div class="units-table-row <?php if ($data[$key]['SUSPENDED'] == 'yes') echo 'disabled'; ?> js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-sort-date="<?= tohtml(strtotime($data[$key]['DATE'].' '.$data[$key]['TIME'])) ?>"
				data-sort-name="<?= tohtml($key) ?>"
				data-sort-disk="<?= tohtml($data[$key]["U_DISK"]) ?>"
				data-sort-user="<?= tohtml($data[$key]["DBUSER"]) ?>"
				data-sort-server="<?= tohtml($data[$key]["HOST"]) ?>"
				data-sort-charset="<?= tohtml($data[$key]["CHARSET"]) ?>">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml( _("Select")) ?>" name="database[]" value="<?= tohtml($key) ?>" <?= tohtml($display_mode) ?>>
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
					</div>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Name")) ?>:</span>
					<?php if ($read_only === true || $data[$key]["SUSPENDED"] == "yes") { ?>
						<?= tohtml($key) ?>
					<?php } else { ?>
						<a href="/edit/db/?<?= tohtml(http_build_query(["database" => $key, "token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Edit Database")) ?>: <?= tohtml($key) ?>">
							<?= tohtml($key) ?>
						</a>
					<?php } ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<?php if (!$read_only) { ?>
						<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
							<?php if ($data[$key]["SUSPENDED"] == "no") { ?>
								<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
									<a
										class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
											href="/edit/db/?<?= tohtml(http_build_query(["database" => $key, "token" => $_SESSION["token"]])) ?>"
										title="<?= tohtml( _("Edit Database")) ?>"
									>
										<i class="fas fa-pencil icon-orange text-amber-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit Database")) ?></span>
									</a>
								</li>
							<?php } ?>
								<?php if ($data[$key]['TYPE'] == 'mysql' && isset($_SESSION['PHPMYADMIN_KEY']) && $_SESSION['PHPMYADMIN_KEY'] != '' && !ipUsed()) { $time = time(); ?>
									<?php
										$hestia_sso_token = password_hash(
											$key . $user_plain . $_SESSION['user_combined_ip'] . $time . $_SESSION['PHPMYADMIN_KEY'],
											PASSWORD_DEFAULT,
										);
										$hestia_sso_url = $db_myadmin_link . "hestia-sso.php?" . http_build_query([
											"host" => $data[$key]["HOST"],
											"database" => $key,
											"user" => $user_plain,
											"exp" => $time,
											"hestia_token" => $hestia_sso_token,
										]);
									?>
									<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
										<a
											class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
											href="<?= tohtml($hestia_sso_url) ?>"
											title="phpMyAdmin" target="_blank"
										>
										<i class="fas fa-right-to-bracket icon-orange text-amber-700"></i>
										<span class="u-hide-desktop xl:hidden!">phpMyAdmin</span>
									</a>
								</li>
							<?php } ?>
							<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/download/database/?<?= tohtml(http_build_query(["database" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Download Database")) ?>"
								>
									<i class="fas fa-download icon-orange text-amber-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Download Database")) ?></span>
								</a>
							</li>
							<li class="units-table-row-action shortcut-s shrink-0" data-key-action="js">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/<?= tohtml($spnd_action) ?>/db/?<?= tohtml(http_build_query(["database" => $key, "token" => $_SESSION["token"]])) ?>"
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
									href="/delete/db/?<?= tohtml(http_build_query(["database" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Delete")) ?>"
									data-confirm-title="<?= tohtml( _("Delete")) ?>"
									data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to delete database %s?"), $key)) ?>"
								>
									<i class="fas fa-trash icon-red text-red-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Delete")) ?></span>
								</a>
							</li>
						</ul>
					<?php } ?>
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
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<?= tohtml($data[$key]["TYPE"]) ?>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Username")) ?>:</span>
					<?= tohtml($data[$key]["DBUSER"]) ?>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Hostname")) ?>:</span>
					<?= tohtml($data[$key]["HOST"]) ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Charset")) ?>:</span>
					<?= tohtml($data[$key]["CHARSET"]) ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d SQL database", "%d SQL databases", $i), $i); ?>
		</p>
	</div>

	<section id="nosql" class="u-mt20 mt-[20px]">
		<h2 class="u-mb10 mb-[10px]"><?= tohtml(_("NoSQL Databases")) ?></h2>
        <?php foreach (["mongodb" => "MongoDB", "redis" => "Redis"] as $service_type => $service_label) { ?>
            <?php if (empty($nosql_data["services"][$service_type])) { ?>
                <div class="alert alert-info nosql-service-status mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-blue-200 bg-blue-50 text-blue-800" role="status" data-nosql-service="<?= tohtml($service_type) ?>">
                    <p><strong><?= tohtml($service_label) ?>:</strong>
                        <?= tohtml(_("Unavailable for management in this panel. An administrator must verify the service connection configuration before databases can be created.")) ?>
                    </p>
                </div>
            <?php } ?>
        <?php } ?>
		<p class="hint u-mb20 text-sm leading-6 text-slate-500 mb-[20px]">
			<?= tohtml(_("MongoDB users are restricted to read and write one database. Redis users are restricted to their key namespace. These entries are not included in W3VJHOST user backups.")) ?>
		</p>
		<p class="hint u-mb20 text-sm leading-6 text-slate-500 mb-[20px]">
			<?= tohtml(_("NoSQL storage is not included in W3VJHOST per-user disk usage or quotas; Redis memory limits are server-wide.")) ?>
		</p>
		<p class="hint u-mb20 text-sm leading-6 text-slate-500 mb-[20px]">
			<?= tohtml(_("Only databases and Redis namespaces created through W3VJHOST appear here; existing service data is not imported automatically.")) ?>
		</p>
		<p class="hint u-mb20 text-sm leading-6 text-slate-500 mb-[20px]">
			<?= tohtml(_("These services listen on localhost. Applications on another server need an SSH tunnel to connect.")) ?>
		</p>
		<?php if (!empty($nosql_data["redis_acl_setup_required"])) { ?>
			<p class="hint u-mb20 text-sm leading-6 text-slate-500 mb-[20px]">
				<?= tohtml(_("Redis needs an administrator to enable persistent ACL storage before Redis namespaces can be managed. This restarts Redis.")) ?>
			</p>
		<?php } ?>
		<?php if (!empty($nosql_credential)) { ?>
			<?php
				$credential_type = $nosql_credential["type"] === "mongodb" ? "MongoDB" : "Redis";
				$credential_entry = null;
				foreach (["mongodb", "redis"] as $service_type) {
					foreach ($nosql_data[$service_type] ?? [] as $entry) {
						if ($entry["TYPE"] === $nosql_credential["type"] && $entry["NAME"] === $nosql_credential["name"]) {
							$credential_entry = $entry;
							break 2;
						}
					}
				}
			?>
			<div class="alert alert-success u-mb20 mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-green-200 bg-green-50 text-green-800 mb-[20px]" role="alert">
				<p class="u-text-bold font-bold">
					<?= tohtml(sprintf(_("Save this %s password now. It is shown only once."), $credential_type)) ?>
				</p>
				<?php if ($credential_entry) { ?>
					<p><?= tohtml(_("Database")) ?>: <?= tohtml($credential_entry["DATABASE"]) ?></p>
					<p><?= tohtml(_("Username")) ?>: <?= tohtml($credential_entry["DBUSER"]) ?></p>
					<p><?= tohtml(_("Host")) ?>: <?= tohtml($credential_entry["HOST"] . ":" . $credential_entry["PORT"]) ?></p>
					<?php if ($nosql_credential["type"] === "redis") { ?>
						<p><?= tohtml(_("Key prefix")) ?>: <?= tohtml($credential_entry["NAMESPACE"]) ?></p>
					<?php } ?>
				<?php } ?>
				<label for="nosql-one-time-password" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml(_("One-time password")) ?></label>
				<input
					id="nosql-one-time-password"
					class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
					type="text"
					autocomplete="off"
					readonly
					value="<?= tohtml($nosql_credential["password"]) ?>"
				>
			</div>
		<?php } ?>

		<?php if (empty($nosql_data["mongodb"]) && empty($nosql_data["redis"])) { ?>
			<p><?= tohtml(!empty($nosql_data["services"]["mongodb"]) || !empty($nosql_data["services"]["redis"]) ? _("No managed NoSQL databases.") : _("NoSQL creation is unavailable until a service connection is configured. No managed entries are registered for this user.")) ?></p>
		<?php } else { ?>
			<div class="units-table w-full text-sm xl:table xl:border-collapse">
				<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Name")) ?></div>
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Service")) ?></div>
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Database or key namespace")) ?></div>
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Username")) ?></div>
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Host")) ?></div>
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Permissions")) ?></div>
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Actions")) ?></div>
				</div>
				<?php foreach (["mongodb", "redis"] as $service_type) { ?>
					<?php foreach ($nosql_data[$service_type] ?? [] as $entry) { ?>
						<?php $service_available = !empty($nosql_data["services"][$service_type]); ?>
						<div class="units-table-row my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500" data-nosql-service="<?= tohtml($service_type) ?>">
							<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
								<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Name")) ?>:</span>
								<?= tohtml($entry["NAME"]) ?>
							</div>
							<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
								<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml(_("Service")) ?>:</span>
								<?= tohtml($service_type === "mongodb" ? "MongoDB" : "Redis") ?>
							</div>
							<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
								<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml(_("Database or key namespace")) ?>:</span>
								<?= tohtml($service_type === "mongodb" ? $entry["DATABASE"] : $entry["NAMESPACE"]) ?>
							</div>
							<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
								<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml(_("Username")) ?>:</span>
								<?= tohtml($entry["DBUSER"]) ?>
							</div>
							<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
								<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml(_("Host")) ?>:</span>
								<?= tohtml($entry["HOST"] . ":" . $entry["PORT"]) ?>
							</div>
							<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
								<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml(_("Permissions")) ?>:</span>
								<?= tohtml($service_type === "mongodb" ? _("Read/write on this database") : _("Read/write in this key namespace")) ?>
							</div>
							<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
								<?php if (!$read_only && $service_available) { ?>
									<form action="/reset/nosql/" method="post" class="u-mb5 mb-[5px]">
										<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
										<input type="hidden" name="ok" value="Reset">
										<input type="hidden" name="type" value="<?= tohtml($service_type) ?>">
										<input type="hidden" name="name" value="<?= tohtml($entry["NAME"]) ?>">
										<button type="submit" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
											<?= tohtml(_("Reset Password")) ?>
										</button>
									</form>
									<a
										class="button button-secondary js-confirm-action inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!"
										href="/delete/nosql/?<?= tohtml(http_build_query([
											"type" => $service_type,
											"name" => $entry["NAME"],
											"token" => $_SESSION["token"],
										])) ?>"
										data-confirm-title="<?= tohtml(_("Delete")) ?>"
										data-confirm-message="<?= tohtml(sprintf(_("Delete NoSQL database or namespace %s? All its data and credentials will be removed."), $entry["NAME"])) ?>"
									>
										<?= tohtml(_("Delete")) ?>
									</a>
								<?php } elseif (!$service_available) { ?>
									<span class="hint text-sm leading-6 text-slate-500"><?= tohtml(_("Service unavailable")) ?></span>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		<?php } ?>
		<?php
			$nosql_count = count($nosql_data["mongodb"] ?? []) + count($nosql_data["redis"] ?? []);
		?>
		<div class="units-table-footer py-4 text-sm text-slate-500">
			<p><?php printf(ngettext("%d NoSQL entry", "%d NoSQL entries", $nosql_count), $nosql_count); ?></p>
		</div>
	</section>

</div>
