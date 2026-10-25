<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a href="javascript:window.history.back();" class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<a href="javascript:location.reload();" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-arrows-rotate icon-green text-green-700"></i><?= tohtml( _("Refresh")) ?>
			</a>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<div class="toolbar-sorting relative flex min-w-0 flex-wrap items-center gap-2 text-sm">
				<button class="toolbar-sorting-toggle js-toggle-sorting-menu rounded px-2 py-1 text-slate-600 hover:bg-slate-100" type="button" title="<?= tohtml( _("Sort items")) ?>">
					<?= tohtml( _("Sort by")) ?>:
					<span class="u-text-bold font-bold">
						<?= tohtml( _("Date")) ?> <i class="fas fa-arrow-down-a-z"></i>
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
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Search Results")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Status")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Search Results")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Date")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Owner")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Type")) ?></div>
		</div>

		<!-- Begin search result item loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;

				if ($value['SUSPENDED'] == 'yes') {
					$status = 'suspended';
					$spnd_action = 'unsuspend';
				} else {
					$status = 'active';
					$spnd_action = 'suspend';
				}

				if ($value['TYPE'] == 'db') {
					$object = 'database';
				} else {
					$object = strtolower($value['TYPE'] . ' ' . $value['KEY']);
				}

				$uniq_id = $value['TYPE'] . '-';
				if ($value['KEY'] == 'ACCOUNT'){
					$uniq_id .= 'acc-';
				}
				$uniq_id .= sha1($value['RESULT']);
			?>
			<div class="units-table-row <?php if ($status == 'suspended') echo 'disabled'; ?> js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-uniq-id="<?= tohtml($uniq_id) ?>"
				data-sort-date="<?= tohtml(strtotime($value['DATE'].' '.$value['TIME'])) ?>"
				data-sort-name="<?= tohtml($value['RESULT']) ?>"
				data-sort-type="<?= tohtml( _($object)) ?>"
				data-sort-owner="<?= tohtml($value["USER"]) ?>"
				data-sort-status="<?= tohtml($status) ?>"
				style="<?php if (($_SESSION['POLICY_SYSTEM_HIDE_ADMIN'] === 'yes') && ($value['USER']) === $_SESSION['ROOT_USER']) { echo 'display: none;'; } ?>">
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<?php
						if ($object === 'web domain') {
							$icon = 'fa-earth-americas';
						}
						if ($object === 'mail domain') {
							$icon = 'fa-envelopes-bulk';
						}
						if ($object === 'dns domain') {
							$icon = 'fa-book-atlas';
						}
						if ($object === 'dns record') {
							$icon = 'fa-book-atlas';
						}
						if ($object === 'database') {
							$icon = 'fa-database';
						}
						if ($object === 'cron job') {
							$icon = 'fa-clock';
						}
					?>
					<i class="fa <?= tohtml($icon) ?> icon-dim text-slate-400"></i>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Status")) ?>:</span>
					<?php if ($status === "active") { ?>
						<i class="fas fa-circle-check icon-green text-green-700"></i>
					<?php } ?>
					<?php if ($status === "suspended") { ?>
						<i class="fas fa-triangle-exclamation icon-orange text-amber-700"></i>
					<?php } ?>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Search Results")) ?>:</span>
					<?php
						$edit_query = [
							"user" => $value["USER"],
						];
						if ($value["KEY"] == "RECORD") {
							$edit_query["domain"] = $value["PARENT"];
							$edit_query["record_id"] = $value["LINK"];
						}
						if ($value["KEY"] == "ACCOUNT") {
							$edit_query["domain"] = $value["PARENT"];
							$edit_query["account"] = $value["LINK"];
						}
						if ($value["KEY"] == "JOB") {
							$edit_query["job"] = $value["LINK"];
						}
						if ($value["KEY"] == "DATABASE") {
							$edit_query["database"] = $value["RESULT"];
						}
						if (($value["KEY"] != "RECORD") && ($value["KEY"] != "ACCOUNT") && ($value["KEY"] != "JOB") && ($value["KEY"] != "DATABASE")) {
							$edit_query[strtolower($value["KEY"])] = $value["RESULT"];
						}

						$edit_lnk = "/edit/" . rawurlencode($value["TYPE"]) . "/?" . http_build_query($edit_query);
					?>
					<?php
						if (($_SESSION['userContext'] === 'admin') && ($_SESSION['user'] !== $_SESSION['ROOT_USER']) && ($value['USER'] === $_SESSION['ROOT_USER']) && ($_SESSION['POLICY_SYSTEM_PROTECTED_ADMIN'] === 'yes')) {
							echo tohtml($value["RESULT"]);
						} else {
							if ($value["USER"] == $_SESSION["user"]) {
								$href = $edit_lnk . "&" . http_build_query(["token" => $_SESSION["token"]]);
							} else {
								$href = "/login/?" . http_build_query([
									"loginas" => $value["USER"],
									"token" => $_SESSION["token"],
									"edit_link" => $edit_lnk,
								]);
							}
							echo '<a href="' . tohtml($href) . '">' . tohtml($value["RESULT"]) . '</a>';
						}
					?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Date")) ?>:</span>
					<time datetime="<?= tohtml($value["DATE"]) ?>">
						<?= tohtml(translate_date($value["DATE"])) ?>
					</time>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Owner")) ?>:</span>
					<a href="/search/?<?= tohtml(http_build_query(["q" => $_GET["q"], "u" => $value["USER"], "token" => $_SESSION["token"]])) ?>">
						<?= tohtml($value["USER"]) ?>
					</a>
					<?php if (!($_SESSION["POLICY_SYSTEM_HIDE_ADMIN"] === "yes" && $value["USER"] === $_SESSION["ROOT_USER"]) && $_SESSION["userContext"] === "admin") { ?>
						<a href="/login/?<?= tohtml(http_build_query(["loginas" => $value["USER"], "token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Log in as")) ?> <?= tohtml($value["USER"]) ?>" class="u-ml5 ml-[5px]">
							<i class="fas fa-right-to-bracket icon-green icon-dim text-green-700 text-slate-400"></i>
							<span class="u-hidden-visually sr-only"><?= tohtml( _("Log in as")) ?> <?= tohtml($value["USER"]) ?></span>
						</a>
					<?php } ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<?= tohtml( _($object)) ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d object", "%d objects", $i), $i); ?>
		</p>
	</div>

</div>
