<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/user/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<a href="/add/package/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Add Package")) ?>
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
					<li data-entity="sort-date" data-sort-as-int="1">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'date') { echo 'active'; } ?>"><?= tohtml( _("Date")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-name">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'name') { echo 'active'; } ?>"><?= tohtml( _("Name")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<form x-data x-bind="BulkEdit" action="/bulk/package/" method="post">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
						<option value=""><?= tohtml( _("Apply to selected")) ?></option>
						<option value="delete"><?= tohtml( _("Delete")) ?></option>
					</select>
					<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml( _("Apply to selected")) ?>">
						<i class="fas fa-arrow-right"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Packages")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>">
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Package")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center">
				<i class="fas fa-terminal" title="<?= tohtml( _("Shell")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Shell")) ?></span>
			</div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center">
				<i class="fas fa-hard-drive" title="<?= tohtml( _("Quota")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Quota")) ?></span>
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
				<i class="fas fa-link" title="<?= tohtml( _("Web Aliases")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Web Aliases")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-book-atlas" title="<?= tohtml( _("DNS Zones")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("DNS Zones")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-globe" title="<?= tohtml( _("DNS Records")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("DNS Records")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-envelopes-bulk" title="<?= tohtml( _("Mail Domains")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Mail Domains")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-inbox" title="<?= tohtml( _("Mail Accounts")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Mail Accounts")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-database" title="<?= tohtml( _("Databases")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Databases")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-clock" title="<?= tohtml( _("Cron Jobs")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Cron Jobs")) ?></span>
			</div>
			<div class="units-table-cell compact u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! text-center">
				<i class="fas fa-file-zipper" title="<?= tohtml( _("Backups")) ?>"></i>
				<span class="u-hidden-visually sr-only"><?= tohtml( _("Backups")) ?></span>
			</div>
		</div>

		<!-- Begin package list item loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;
			?>
			<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-sort-date="<?= tohtml(strtotime($data[$key]["DATE"] . " " . $data[$key]["TIME"])) ?>"
				data-sort-name="<?= tohtml($key) ?>"
				data-sort-bandwidth="<?= tohtml($data[$key]["BANDWIDTH"]) ?>"
				data-sort-disk="<?= tohtml($data[$key]["DISK_QUOTA"]) ?>">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml( _("Select")) ?>" name="package[]" value="<?= tohtml($key) ?>">
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
					</div>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Package")) ?>:</span>
					<?php if ($key == "system") { ?>
						<?= tohtml($key) ?>
					<?php } else { ?>
						<a href="/edit/package/?<?= tohtml(http_build_query(["package" => $key, "token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Edit Package")) ?>: <?= tohtml($key) ?>">
							<?= tohtml($key) ?>
						</a>
					<?php } ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<?php if ($key != "system") { ?>
							<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/edit/package/?<?= tohtml(http_build_query(["package" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Edit Package")) ?>"
								>
									<i class="fas fa-pencil icon-orange text-amber-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit Package")) ?></span>
								</a>
							</li>
						<?php } ?>
						<li class="units-table-row-action shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/copy/package/?<?= tohtml(http_build_query(["package" => $key, "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml( _("Duplicate")) ?>"
							>
								<i class="fas fa-clone icon-teal text-teal-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Duplicate")) ?></span>
							</a>
						</li>
						<?php if ($key != "system") { ?>
							<li class="units-table-row-action shortcut-delete shrink-0" data-key-action="js">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/delete/package/?<?= tohtml(http_build_query(["package" => $key, "token" => $_SESSION["token"]])) ?>"
									title="<?= tohtml( _("Delete")) ?>"
									data-confirm-title="<?= tohtml( _("Delete")) ?>"
									data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to delete package %s?"), $key)) ?>"
								>
									<i class="fas fa-trash icon-red text-red-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Delete")) ?></span>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Shell")) ?>:</span>
					<?php if ($data[$key]["SHELL"] == "nologin") { ?>
						<i class="fas fa-circle-minus icon-large text-base" title="<?= tohtml( _("SSH Access")) ?>: <?= tohtml($data[$key]["SHELL"]) ?>"> </i>
					<?php } else { ?>
						<i class="fas fa-circle-check icon-green icon-large text-green-700 text-base"></i>
					<?php } ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Quota")) ?>:</span>
					<span title="<?= tohtml( _("Quota")) ?>: <?= tohtml(humanize_usage_size($data[$key]["DISK_QUOTA"])) ?> <?= tohtml(humanize_usage_measure($data[$key]["DISK_QUOTA"])) ?>">
						<?php if (preg_match("/[a-z]/i", $data[$key]["DISK_QUOTA"])): ?>
							<span class="u-text-bold font-bold">
								&infin;
							</span>
						<?php else: ?>
							<span class="u-text-bold font-bold">
								<?= tohtml(humanize_usage_size($data[$key]["DISK_QUOTA"])) ?>
							</span>
							<span class="u-text-small text-xs">
								<?= tohtml(humanize_usage_measure($data[$key]["DISK_QUOTA"])) ?>
							</span>
						<?php endif; ?>
					</span>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Bandwidth")) ?>:</span>
					<span title="<?= tohtml( _("Bandwidth")) ?>: <?= tohtml(humanize_usage_size($data[$key]["BANDWIDTH"])) ?> <?= tohtml(humanize_usage_measure($data[$key]["BANDWIDTH"])) ?>">
						<?php if ($data[$key]["BANDWIDTH"] == "unlimited") { ?>
							<span class="u-text-bold font-bold">
								&infin;
							</span>
						<?php } else { ?>
							<span class="u-text-bold font-bold">
								<?= tohtml(humanize_usage_size($data[$key]["BANDWIDTH"])) ?>
							</span>
							<span class="u-text-small text-xs">
								<?= tohtml(humanize_usage_measure($data[$key]["BANDWIDTH"])) ?>
							</span>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Web Domains")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("Web Domains")) ?>: <?= tohtml($data[$key]["WEB_DOMAINS"]) ?>">
						<?php if ($data[$key]["WEB_DOMAINS"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["WEB_DOMAINS"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Web Aliases")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("Web Aliases")) ?>: <?= tohtml($data[$key]["WEB_ALIASES"]) ?>">
						<?php if ($data[$key]["WEB_ALIASES"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["WEB_ALIASES"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("DNS Zones")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("DNS Zones")) ?>: <?= tohtml($data[$key]["DNS_DOMAINS"]) ?>">
						<?php if ($data[$key]["DNS_DOMAINS"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["DNS_DOMAINS"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("DNS Records")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("DNS Records")) ?>: <?= tohtml($data[$key]["DNS_RECORDS"]) ?>">
						<?php if ($data[$key]["DNS_RECORDS"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["DNS_RECORDS"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Mail Domains")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("Mail Domains")) ?>: <?= tohtml($data[$key]["MAIL_DOMAINS"]) ?>">
						<?php if ($data[$key]["MAIL_DOMAINS"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["MAIL_DOMAINS"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Mail Accounts")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("Mail Accounts")) ?>: <?= tohtml($data[$key]["MAIL_ACCOUNTS"]) ?>">
						<?php if ($data[$key]["MAIL_ACCOUNTS"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["MAIL_ACCOUNTS"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Databases")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("Databases")) ?>: <?= tohtml($data[$key]["DATABASES"]) ?>">
						<?php if ($data[$key]["DATABASES"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["DATABASES"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Cron Jobs")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("Cron Jobs")) ?>: <?= tohtml($data[$key]["CRON_JOBS"]) ?>">
						<?php if ($data[$key]["CRON_JOBS"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["CRON_JOBS"]) ?>
						<?php } ?>
					</span>
				</div>
				<div class="units-table-cell compact u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle px-2! font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Backups")) ?>:</span>
					<span class="units-table-badge inline-flex min-w-6 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-600" title="<?= tohtml( _("Backups")) ?>: <?= tohtml($data[$key]["BACKUPS"]) ?>">
						<?php if ($data[$key]["BACKUPS"] == "unlimited") { ?>
							&infin;
						<?php } else { ?>
							<?= tohtml($data[$key]["BACKUPS"]) ?>
						<?php } ?>
					</span>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d package", "%d packages", $i), $i); ?>
		</p>
	</div>

</div>
