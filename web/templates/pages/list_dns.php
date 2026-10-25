<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true) { ?>
				<a href="/add/dns/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Add DNS Domain")) ?>
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
					<li data-entity="sort-date" data-sort-as-int="1">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'date') { echo 'active'; } ?>"><?= tohtml( _("Date")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-expire" data-sort-as-int="1">
						<span class="name"><?= tohtml( _("Expire")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-ip">
						<span class="name"><?= tohtml( _("IP Address")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-name">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'name') { echo 'active'; } ?>"><?= tohtml( _("Name")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-records">
						<span class="name"><?= tohtml( _("Records")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<?php if ($read_only !== true) { ?>
					<form x-data x-bind="BulkEdit" action="/bulk/dns/" method="post">
						<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
							<option value=""><?= tohtml( _("Apply to selected")) ?></option>
							<?php if ($_SESSION["userContext"] === "admin") { ?>
								<option value="rebuild"><?= tohtml( _("Rebuild")) ?></option>
							<?php } ?>
							<option value="suspend"><?= tohtml( _("Suspend")) ?></option>
							<option value="unsuspend"><?= tohtml( _("Unsuspend")) ?></option>
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

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("DNS Records")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>" <?= tohtml($display_mode) ?>>
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Name")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Records")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Template")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("TTL")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("SOA")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("DNSSEC")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Expiration Date")) ?></div>
		</div>

		<!-- Begin DNS zone list item loop -->
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
					if ($data[$key]['DNSSEC'] !== 'yes') {
						$dnssec_icon = 'fa-circle-xmark';
						$dnssec_title = _('Disabled');
					} else {
						$dnssec_icon = 'fa-circle-check';
						$dnssec_title = _('Enabled');
					}
				} else {
					$status = 'active';
					$spnd_action = 'suspend';
					$spnd_action_title = _('Suspend');
					$spnd_icon = 'fa-pause';
					$spnd_icon_class = 'icon-highlight text-slate-700';
					$spnd_confirmation = _('Are you sure you want to suspend domain %s?');
					if ($data[$key]['DNSSEC'] !== 'yes') {
						$dnssec_icon = 'fa-circle-xmark icon-red text-red-700';
						$dnssec_title = _('Disabled');
					} else {
						$dnssec_icon = 'fa-circle-check icon-green text-green-700';
						$dnssec_title = _('Enabled');
					}
				}
			?>
			<div class="units-table-row <?php if ($status == 'suspended') echo 'disabled'; ?> js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-sort-ip="<?= tohtml(str_replace('.', '', $data[$key]['IP'])) ?>"
				data-sort-date="<?= tohtml(strtotime($data[$key]['DATE'].' '.$data[$key]['TIME'])) ?>"
				data-sort-name="<?= tohtml($key) ?>"
				data-sort-expire="<?= tohtml(strtotime($data[$key]['EXP'])) ?>"
				data-sort-records="<?= tohtml((int)$data[$key]['RECORDS']) ?>">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml( _("Select")) ?>" name="domain[]" value="<?= tohtml($key) ?>" <?= tohtml($display_mode) ?>>
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
					</div>
				</div>
					<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
						<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Name")) ?>:</span>
						<a href="/list/dns/?<?= tohtml(http_build_query(array("domain" => $key, "token" => $_SESSION["token"]))) ?>" title="<?= tohtml( _("DNS Records")) ?>: <?= tohtml($key) ?>">
							<?= tohtml($key) ?>
						</a>
						<?= empty($data[$key]["SRC"]) ? "" : '<br>⇢ <span class="u-text-small">' . tohtml($data[$key]["SRC"]) . "</span>" ?>
					</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<?php if (!$read_only) { ?>
						<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
							<?php if ($data[$key]["SUSPENDED"] == "no") { ?>
								<li class="units-table-row-action shortcut-n shrink-0" data-key-action="href">
									<a
										class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
											href="/add/dns/?<?= tohtml(http_build_query(array("domain" => $key, "token" => $_SESSION["token"]))) ?>"
										title="<?= tohtml( _("Add DNS Record")) ?>"
									>
										<i class="fas fa-circle-plus icon-green text-green-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Add DNS Record")) ?></span>
									</a>
								</li>
								<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
									<a
										class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
											href="/edit/dns/?<?= tohtml(http_build_query(array("domain" => $key, "token" => $_SESSION["token"]))) ?>"
										title="<?= tohtml( _("Edit DNS Domain")) ?>"
									>
										<i class="fas fa-pencil icon-orange text-amber-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit DNS Domain")) ?></span>
									</a>
								</li>
								<?php if ($data[$key]["DNSSEC"] == "yes") { ?>
									<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
										<a
											class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
												href="/list/dns/?<?= tohtml(http_build_query(array("domain" => $key, "action" => "dnssec", "token" => $_SESSION["token"]))) ?>"
											title="<?= tohtml( _("View Public DNSSEC Key")) ?>"
										>
											<i class="fas fa-key icon-orange text-amber-700"></i>
											<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("View Public DNSSEC Key")) ?></span>
										</a>
									</li>
								<?php } ?>
							<?php } ?>
							<li class="units-table-row-action shortcut-l shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/list/dns/?<?= tohtml(http_build_query(array("domain" => $key, "token" => $_SESSION["token"]))) ?>"
									title="<?= tohtml( _("DNS Records")) ?>"
								>
									<i class="fas fa-list icon-lightblue text-sky-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("DNS Records")) ?></span>
								</a>
							</li>
							<li class="units-table-row-action shortcut-s shrink-0" data-key-action="js">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/<?= tohtml($spnd_action) ?>/dns/?<?= tohtml(http_build_query(array("domain" => $key, "token" => $_SESSION["token"]))) ?>"
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
									href="/delete/dns/?<?= tohtml(http_build_query(array("domain" => $key, "token" => $_SESSION["token"]))) ?>"
									title="<?= tohtml( _("Delete")) ?>"
									data-confirm-title="<?= tohtml( _("Delete")) ?>"
									data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to delete domain %s?"), $key)) ?>"
								>
									<i class="fas fa-trash icon-red text-red-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Delete")) ?></span>
								</a>
							</li>
						</ul>
					<?php } ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Records")) ?>:</span>
					<?php if ($data[$key]['RECORDS']) {
						echo '<span>'.$data[$key]['RECORDS'].'</span>';
					} else {
						echo '<span>0</span>';
					} ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Template")) ?>:</span>
					<span class="u-text-bold font-bold">
						<?= tohtml($data[$key]["TPL"]) ?>
					</span>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("TTL")) ?>:</span>
					<?= tohtml($data[$key]["TTL"]) ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("SOA")) ?>:</span>
					<?= tohtml($data[$key]["SOA"]) ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("DNSSEC")) ?>:</span>
					<i class="fas <?= tohtml($dnssec_icon) ?>" title="<?= tohtml($dnssec_title) ?>"></i>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Expiration Date")) ?>:</span>
					<time class="u-text-bold font-bold" datetime="<?= tohtml($data[$key]["EXP"]) ?>">
						<?= tohtml($data[$key]["EXP"]) ?>
					</time>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d DNS zone", "%d DNS zones", $i), $i); ?>
		</p>
	</div>

</div>
