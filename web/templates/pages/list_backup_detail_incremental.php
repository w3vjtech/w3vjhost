<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/backup/incremental/"><i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?></a>
			<?php if ($read_only !== true) { ?>
			<a href="/schedule/restore/incremental/?<?= tohtml(http_build_query(array("token" => $_SESSION["token"], "snapshot" => $_GET["snapshot"]))) ?>" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!"><i class="fas fa-arrow-rotate-left icon-green text-green-700"></i><?= tohtml( _("Restore All")) ?></a>
			<?php } ?>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<?php if ($read_only !== true) { ?>
				<form x-data x-bind="BulkEdit" action="/bulk/restore/incremental/" method="post">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
					<input type="hidden" name="snapshot" value="<?= tohtml($_GET["snapshot"]) ?>">
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
						<option value=""><?= tohtml( _("Apply to selected")) ?></option>
						<option value="restore"><?= tohtml( _("Restore Snapshot")) ?></option>
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

<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Backup Details")) ?></h1>

<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
	<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
		<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
			<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>">
		</div>
		<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Type")) ?></div>
		<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Details")) ?></div>
		<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Restore")) ?></div>
	</div>
	<?php
		$web = explode(',',$data['snapshot']['WEB']);
		foreach ($web as $key) {
			if (!empty($key)) {
				++$i;
		?>
		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<div class="flex items-center gap-2">
					<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" name="web[]" value="<?= tohtml($key) ?>">
					<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
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
						<a href="/schedule/restore/incremental/?<?= tohtml(http_build_query(array("snapshot" => $_GET["snapshot"], "type" => "web", "object" => $key, "token" => $_SESSION["token"]))) ?>" title="<?= tohtml( _("Restore")) ?>">
						<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
						<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php }} ?>

		<?php
		$mail = explode(',',$data['snapshot']['MAIL']);
		foreach ($mail as $key) {
			if (!empty($key)) {
				++$i;
		?>
		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<div class="flex items-center gap-2">
					<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" name="mail[]" value="<?= tohtml($key) ?>">
					<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
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
							<a href="/schedule/restore/incremental/?<?= tohtml(http_build_query(array("snapshot" => $_GET["snapshot"], "type" => "mail", "object" => $key, "token" => $_SESSION["token"]))) ?>" title="<?= tohtml( _("Restore")) ?>">
						<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
						<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php }} ?>

		<?php
		$dns = explode(',',$data['snapshot']['DNS']);
		foreach ($dns as $key) {
			if (!empty($key)) {
				++$i;
		?>
		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<div class="flex items-center gap-2">
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" name="dns[]" value="<?= tohtml($key) ?>">
					<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
				</div>
			</div>
			<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
				<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
				<i class="fas fa-book-atlas u-mr5 mr-[5px]"></i><?= tohtml( _("DNS Domain")) ?>
			</div>
			<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
					<?= tohtml($key) ?>
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
					<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a href="/schedule/restore/incremental/?<?= tohtml(http_build_query(array("snapshot" => $_GET["snapshot"], "type" => "dns", "object" => $key, "token" => $_SESSION["token"]))) ?>" title="<?= tohtml( _("Restore")) ?>">
						<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
						<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php }} ?>

		<?php
		$db = explode(',',$data['snapshot']['DB']);
		foreach ($db as $key) {
			if (!empty($key)) {
				++$i;
		?>
		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<div class="flex items-center gap-2">
					<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" name="db[]" value="<?= tohtml($key) ?>">
					<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
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
							<a href="/schedule/restore/incremental/?<?= tohtml(http_build_query(array("snapshot" => $_GET["snapshot"], "type" => "db", "object" => $key, "token" => $_SESSION["token"]))) ?>" title="<?= tohtml( _("Restore")) ?>">
						<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
						<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php }} ?>

	<?php
	$cron = explode(',',$data['snapshot']['CRON']);
	foreach ($cron as $key) {
		if (!empty($key)) {
			++$i;
	?>
	<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
		<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
			<div class="flex items-center gap-2">
				<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" name="cron[]" value="<?= tohtml($key) ?>">
				<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
			</div>
		</div>
		<div class="units-table-cell units-table-heading-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800">
			<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
			<i class="fas fa-clock u-mr5 mr-[5px]"></i><?= tohtml( _("Cronjob")) ?>
		</div>
		<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
			<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Details")) ?>:</span>
				<?= tohtml($key) ?>
		</div>
		<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
			<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
				<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
					<a href="/schedule/restore/incremental/?<?= tohtml(http_build_query(array("snapshot" => $_GET["snapshot"], "type" => "cron", "object" => $key, "token" => $_SESSION["token"]))) ?>" title="<?= tohtml( _("Restore")) ?>">
					<i class="fas fa-arrow-rotate-left icon-green text-green-700"></i>
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restore")) ?></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<?php }} ?>
</div>

<footer class="app-footer border-t border-slate-200 bg-white py-4 text-xs text-slate-500">
	<div class="container mx-auto w-full max-w-none px-4 md:px-6 flex flex-wrap items-center justify-between gap-3">
		<p>
			<?php printf(ngettext("%d item", "%d items", $i), $i); ?>
		</p>
	</div>
</footer>
