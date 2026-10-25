<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
			<div class="toolbar-buttons flex flex-wrap items-center gap-2">
				<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/backup/">
					<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
				</a>
				<?php if ($read_only !== true) { ?>
					<a href="/schedule/restore/?<?= tohtml(http_build_query(array("token" => $_SESSION["token"], "backup" => $_GET["backup"]))) ?>" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
						<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i><?= tohtml( _("Restore All")) ?>
					</a>
				<?php } ?>
			</div>
			<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
				<?php if ($read_only !== true) { ?>
					<form x-data x-bind="BulkEdit" action="/bulk/restore/" method="post">
						<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
						<input type="hidden" name="backup" value="<?= tohtml($_GET["backup"]) ?>">
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
							<option value=""><?= tohtml( _("Apply to selected")) ?></option>
							<option value="restore"><?= tohtml( _("Restore")) ?></option>
						</select>
						<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml( _("Apply to selected")) ?>">
							<i class="fas fa-arrow-right"></i>
						</button>
					</form>
				<?php } ?>
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

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Backup Details")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>" <?= tohtml($display_mode) ?>>
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Type")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Details")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Restore")) ?></div>
		</div>

			<!-- List web domains -->
			<?php
				$item_count = 0;
				$backup = $_GET['backup'];
				$web_index = 0;
				$web = explode(',',$data[$backup]['WEB']);
				foreach ($web as $key) {
					if (!empty($key)) {
						++$web_index;
						++$item_count;
				?>
				<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						<div>
							<input id="check-web<?= tohtml($web_index) ?>" class="js-unit-checkbox" type="checkbox" name="web[]" value="<?= tohtml($key) ?>">
							<label for="check-web<?= tohtml($web_index) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
						</div>
					</div>
				<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<i class="fas fa-earth-americas u-mr5 mr-[5px]"></i><?= tohtml( _("Web Domain")) ?>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
					<?= tohtml($key) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/schedule/restore/?<?= tohtml(http_build_query(array("backup" => $backup, "type" => "web", "object" => $key, "token" => $_SESSION["token"]))) ?>"
								title="<?= tohtml( _("Restore")) ?>"
								data-confirm-title="<?= tohtml( _("Restore")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to restore %s?"), $key)) ?>"
							>
								<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		<?php }} ?>

		<!-- List mail domains -->
			<?php
				$mail_index = 0;
				$mail = explode(',',$data[$backup]['MAIL']);
				foreach ($mail as $key) {
					if (!empty($key)) {
						++$mail_index;
						++$item_count;
				?>
				<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						<div>
							<input id="check-mail<?= tohtml($mail_index) ?>" class="js-unit-checkbox" type="checkbox" name="mail[]" value="<?= tohtml($key) ?>">
							<label for="check-mail<?= tohtml($mail_index) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
						</div>
					</div>
				<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<i class="fas fa-envelopes-bulk u-mr5 mr-[5px]"></i><?= tohtml( _("Mail Domain")) ?>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
					<?= tohtml($key) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/schedule/restore/?<?= tohtml(http_build_query(array("backup" => $backup, "type" => "mail", "object" => $key, "token" => $_SESSION["token"]))) ?>"
								title="<?= tohtml( _("Restore")) ?>"
								data-confirm-title="<?= tohtml( _("Restore")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to restore %s?"), $key)) ?>"
							>
								<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		<?php }} ?>

		<!-- List DNS zones -->
			<?php
				$dns_index = 0;
				$dns = explode(',',$data[$backup]['DNS']);
				foreach ($dns as $key) {
					if (!empty($key)) {
						++$dns_index;
						++$item_count;
				?>
				<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						<div>
							<input id="check-dns<?= tohtml($dns_index) ?>" class="js-unit-checkbox" type="checkbox" name="dns[]" value="<?= tohtml($key) ?>">
							<label for="check-dns<?= tohtml($dns_index) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
						</div>
					</div>
				<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<i class="fas fa-book-atlas u-mr5 mr-[5px]"></i><?= tohtml( _("DNS Zone")) ?>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
					<?= tohtml($key) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/schedule/restore/?<?= tohtml(http_build_query(array("backup" => $backup, "type" => "dns", "object" => $key, "token" => $_SESSION["token"]))) ?>"
								title="<?= tohtml( _("Restore")) ?>"
								data-confirm-title="<?= tohtml( _("Restore")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to restore %s?"), $key)) ?>"
							>
								<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		<?php }} ?>

		<!-- List Databases -->
			<?php
				$db_index = 0;
				$db = explode(',',$data[$backup]['DB']);
				foreach ($db as $key) {
					if (!empty($key)) {
						++$db_index;
						++$item_count;
				?>
				<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						<div>
							<input id="check-db<?= tohtml($db_index) ?>" class="js-unit-checkbox" type="checkbox" name="db[]" value="<?= tohtml($key) ?>">
							<label for="check-db<?= tohtml($db_index) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
						</div>
					</div>
				<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<i class="fas fa-database u-mr5 mr-[5px]"></i><?= tohtml( _("Database")) ?>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
					<?= tohtml($key) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/schedule/restore/?<?= tohtml(http_build_query(array("backup" => $backup, "type" => "db", "object" => $key, "token" => $_SESSION["token"]))) ?>"
								title="<?= tohtml( _("Restore")) ?>"
								data-confirm-title="<?= tohtml( _("Restore")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to restore %s?"), $key)) ?>"
							>
								<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		<?php }} ?>

			<!-- List Cron Jobs -->
			<?php
				$cron_index = 0;
				if (!empty($data[$backup]["CRON"])) {
					++$cron_index;
					++$item_count;
			?>
				<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						<div>
							<input id="check-cron<?= tohtml($cron_index) ?>" class="js-unit-checkbox" type="checkbox" name="cron" value="yes">
							<label for="check-cron<?= tohtml($cron_index) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
						</div>
					</div>
				<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<i class="fas fa-clock u-mr5 mr-[5px]"></i><?= tohtml( _("Cron Jobs")) ?>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
					<?= tohtml( _("Jobs")) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/schedule/restore/?<?= tohtml(http_build_query(array("backup" => $backup, "type" => "cron", "object" => "records", "token" => $_SESSION["token"]))) ?>"
									title="<?= tohtml( _("Restore")) ?>"
									data-confirm-title="<?= tohtml( _("Restore")) ?>"
									data-confirm-message="<?= tohtml( _("Are you sure you want to restore cron jobs?")) ?>"
								>
									<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<?php } ?>

		<!-- List user directories -->
			<?php
				$udir_index = 0;
				$udir = explode(',',$data[$backup]['UDIR']);
				foreach ($udir as $key) {
					if (!empty($key)) {
						++$udir_index;
						++$item_count;
				?>
				<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
					<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						<div>
							<input id="check-udir<?= tohtml($udir_index) ?>" class="js-unit-checkbox" type="checkbox" name="udir[]" value="<?= tohtml($key) ?>">
							<label for="check-udir<?= tohtml($udir_index) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
						</div>
					</div>
				<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
					<i class="fas fa-folder-open u-mr5 mr-[5px]"></i><?= tohtml( _("User Directory")) ?>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
					<?= tohtml($key) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/schedule/restore/?<?= tohtml(http_build_query(array("backup" => $backup, "type" => "udir", "object" => $key, "token" => $_SESSION["token"]))) ?>"
								title="<?= tohtml( _("Restore")) ?>"
								data-confirm-title="<?= tohtml( _("Restore")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to restore %s?"), $key)) ?>"
							>
								<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		<?php }} ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
				<?php printf(ngettext("%d item", "%d items", $item_count), $item_count); ?>
			</p>
		</div>

</div>
