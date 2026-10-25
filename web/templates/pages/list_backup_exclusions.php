<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/backup/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<a href="/edit/backup/exclusions/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-pencil icon-orange text-amber-700"></i><?= tohtml( _("Edit Backup Exclusions")) ?>
			</a>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
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

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Backup Exclusions")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Type")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Value")) ?></div>
		</div>

		<!-- Begin list of backup exclusions by type -->
		<?php foreach ($data as $key => $value) { ?>
			<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Type")) ?>:</span>
					<?= tohtml($key) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Value")) ?>:</span>
					<?php
						if (empty($value)) {
							echo _("No exclusions");
						}
						foreach ($value as $ex_key => $ex_value) {
							echo "<span class='u-text-bold'>" . $ex_key . " </span>" . $ex_value . "<br>";
						}
					?>
				</div>
			</div>
		<?php } ?>
	</div>

</div>
