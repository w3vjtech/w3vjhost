<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a href="/add/user/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Add User")) ?>
			</a>
			<a href="/list/package/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-box-open icon-orange text-amber-700"></i><?= tohtml( _("Packages")) ?>
			</a>
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
					<li data-entity="sort-package">
						<span class="name"><?= tohtml( _("Package")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-name">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'name') { echo 'active'; } ?>"><?= tohtml( _("Name")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<form x-data x-bind="BulkEdit" action="/bulk/user/" method="post">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
						<option value=""><?= tohtml( _("Apply to selected")) ?></option>
						<option value="rebuild"><?= tohtml( _("Rebuild All")) ?></option>
						<option value="rebuild user"><?= tohtml( _("Rebuild User Profile")) ?></option>
						<option value="rebuild web"><?= tohtml( _("Rebuild Web Domains")) ?></option>
						<option value="rebuild dns"><?= tohtml( _("Rebuild DNS Zones")) ?></option>
						<option value="rebuild mail"><?= tohtml( _("Rebuild Mail Domains")) ?></option>
						<option value="rebuild db"><?= tohtml( _("Rebuild Databases")) ?></option>
						<option value="rebuild cron"><?= tohtml( _("Rebuild Cron Jobs")) ?></option>
						<option value="update counters"><?= tohtml( _("Update Usage Counters")) ?></option>
						<option value="suspend"><?= tohtml( _("Suspend")) ?></option>
						<option value="unsuspend"><?= tohtml( _("Unsuspend")) ?></option>
						<option value="delete"><?= tohtml( _("Delete")) ?></option>
					</select>
					<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml( _("Apply to selected")) ?>">
						<i class="fas fa-arrow-right"></i>
					</button>
				</form>
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

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Users")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>">
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Name")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Package")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("IPs")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center">
				<i class="fas fa-hard-drive" title="<?= tohtml( _("Disk")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Disk")) ?></span>
			</div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center">
				<i class="fas fa-right-left" title="<?= tohtml( _("Bandwidth")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Bandwidth")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-earth-americas" title="<?= tohtml( _("Web Domains")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Web Domains")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-book-atlas" title="<?= tohtml( _("DNS Zones")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("DNS Zones")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-envelopes-bulk" title="<?= tohtml( _("Mail Domains")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Mail Domains")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-database" title="<?= tohtml( _("Databases")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Databases")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-file-zipper" title="<?= tohtml( _("Backups")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Backups")) ?></span>
			</div>
		</div>

		<!-- Begin user list item loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;
				if ($data[$key]['SUSPENDED'] == 'yes') {
					$status = 'suspended';
					$spnd_action = 'unsuspend';
					$spnd_action_title = _('Unsuspend');
					$spnd_icon = 'fa-play';
					$spnd_icon_class = 'icon-green text-green-700';
					$spnd_confirmation = _('Are you sure you want to unsuspend user %s?');
				} else {
					$status = 'active';
					$spnd_action = 'suspend';
					$spnd_action_title = _('Suspend');
					$spnd_icon = 'fa-pause';
					$spnd_icon_class = 'icon-highlight text-slate-700';
					$spnd_confirmation = _('Are you sure you want to suspend user %s?');
				}
			?>
			<div class="units-table-row <?php if ($status == 'suspended') echo 'disabled'; ?> js-unit <?php if (($_SESSION['POLICY_SYSTEM_HIDE_ADMIN'] === 'yes') && ($_SESSION['user'] !== $_SESSION['ROOT_USER']) && ($key === $_SESSION['ROOT_USER'])) { echo 'u-hidden'; } ?> my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-sort-date="<?= tohtml(strtotime($data[$key]['DATE'].' '.$data[$key]['TIME'])) ?>"
				data-sort-name="<?= tohtml(strtolower($key)) ?>"
				data-sort-package="<?= tohtml(strtolower($data[$key]['PACKAGE'])) ?>"
				data-sort-bandwidth="<?= tohtml($data[$key]["U_BANDWIDTH"]) ?>"
				data-sort-disk="<?= tohtml($data[$key]["U_DISK"]) ?>">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml( _("Select")) ?>" name="user[]" value="<?= tohtml($key) ?>">
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
					</div>
				</div>
				<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Name")) ?>:</span>
					<?php if ($key == $user_plain) { ?>
						<a href="/edit/user/?<?= tohtml(http_build_query(["token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Edit User")) ?>">
							<span class="u-text-bold font-bold">
								<?= tohtml($key) ?>
							</span>
							(<?= tohtml($data[$key]["NAME"]) ?>)
						</a>
					<?php } else { ?>
						<a href="/login/?<?= tohtml(http_build_query(["loginas" => $key, "token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Log in as")) ?> <?= tohtml($key) ?>">
							<span class="u-text-bold font-bold">
								<?= tohtml($key) ?>
							</span>
							(<?= tohtml($data[$key]["NAME"]) ?>)
						</a>
					<?php } ?>
					<p class="u-max-width200 u-text-truncate truncate max-w-[200px]">
						<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Email")) ?>:</span>
						<span title="<?= tohtml($data[$key]["CONTACT"]) ?>"><?= tohtml($data[$key]["CONTACT"]) ?></span>
					</p>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<?php if ($key == $user_plain) { ?>
							<li class="units-table-row-action shrink-0">
								<i class="fas fa-user-check" title="<?= tohtml($key) ?> (<?= tohtml($data[$key]["NAME"]) ?>)"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml($key) ?> (<?= tohtml($data[$key]["NAME"]) ?>)</span>
							</li>
						<?php } else { ?>
							<li class="units-table-row-action shrink-0">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/login/?<?= tohtml(http_build_query(["loginas" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Log in as")) ?> <?= tohtml($key) ?>"
								>
									<i class="fas fa-right-to-bracket icon-green text-green-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Log in as")) ?> <?= tohtml($key) ?></span>
								</a>
							</li>
						<?php } ?>
						<?php if (!($_SESSION["userContext"] === "admin" && $key == $_SESSION['ROOT_USER'] && $_SESSION["user"] != $_SESSION['ROOT_USER'])) { ?>
							<?php if ($key == $user_plain) { ?>
							<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/edit/user/?<?= tohtml(http_build_query(["token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Edit User")) ?>"
								>
									<i class="fas fa-pencil icon-orange text-amber-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit User")) ?></span>
								</a>
							</li>
							<?php } else { ?>
<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/login/?<?= tohtml(http_build_query(["loginas" => $key, "token" => $_SESSION["token"], "edit_link" => "/edit/user/"])) ?>"
									title="<?= tohtml( _("Edit User")) ?>"
								>
									<i class="fas fa-pencil icon-orange text-amber-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit User")) ?></span>
								</a>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if (!($key == $_SESSION['ROOT_USER'] || $key == $user_plain)) { ?>
							<li class="units-table-row-action shortcut-s shrink-0" data-key-action="js">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/<?= tohtml($spnd_action) ?>/user/?<?= tohtml(http_build_query(["user" => $key, "token" => $_SESSION["token"]])) ?>"
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
									href="/delete/user/?<?= tohtml(http_build_query(["user" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Delete")) ?>"
									data-confirm-title="<?= tohtml( _("Delete")) ?>"
									data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to delete user %s?"), $key)) ?>"
								>
									<i class="fas fa-trash icon-red text-red-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Delete")) ?></span>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Package")) ?>:</span>
					<?php if ($data[$key]["PACKAGE"] === "system") { ?>
						<?= tohtml($data[$key]["PACKAGE"]) ?>
					<?php } else { ?>
						<a href="/edit/package/?<?= tohtml(http_build_query(["package" => $data[$key]["PACKAGE"], "token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Edit Package")) ?>">
							<?= tohtml($data[$key]["PACKAGE"]) ?>
						</a>
					<?php } ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IPs")) ?>:</span>
					<?= tohtml($data[$key]["IP_OWNED"]) ?>
				</div>
				<div class="units-table-cell u-text-center-desktop u-text-no-wrap min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center whitespace-nowrap">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Disk")) ?>:</span>
					<span class="u-text-bold font-bold">
						<?= tohtml(humanize_usage_size($data[$key]["U_DISK"], 1)) ?>
					</span>
					<span class="u-text-small text-xs">
						<?= tohtml(humanize_usage_measure($data[$key]["U_DISK"])) ?>
					</span> /
					<span class="u-text-bold font-bold">
						<?= tohtml(humanize_usage_size($data[$key]["DISK_QUOTA"], 1)) ?>
					</span>
					<span class="u-text-small text-xs">
						<?= tohtml(humanize_usage_measure($data[$key]["DISK_QUOTA"])) ?>
					</span>
				</div>
				<div class="units-table-cell u-text-center-desktop u-text-no-wrap min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center whitespace-nowrap">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Bandwidth")) ?>:</span>
					<span class="u-text-bold font-bold">
						<?= tohtml(humanize_usage_size($data[$key]["U_BANDWIDTH"], 1)) ?>
					</span>
					<span class="u-text-small text-xs">
						<?= tohtml(humanize_usage_measure($data[$key]["U_BANDWIDTH"])) ?>
					</span> /
					<span class="u-text-bold font-bold">
						<?= tohtml(humanize_usage_size($data[$key]["BANDWIDTH"], 1)) ?>
					</span>
					<span class="u-text-small text-xs">
						<?= tohtml(humanize_usage_measure($data[$key]["BANDWIDTH"])) ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Web Domains")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600">
						<?= tohtml($data[$key]["U_WEB_DOMAINS"]) ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("DNS Zones")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600">
						<?= tohtml($data[$key]["U_DNS_DOMAINS"]) ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Mail Domains")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600">
						<?= tohtml($data[$key]["U_MAIL_DOMAINS"]) ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Databases")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600">
						<?= tohtml($data[$key]["U_DATABASES"]) ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Backups")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600">
						<?= tohtml($data[$key]["U_BACKUPS"]) ?>
					</span>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d user account", "%d user accounts", $i), $i); ?>
		</p>
	</div>

</div>
