<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/firewall/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<a href="/add/firewall/banlist/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Ban IP Address")) ?>
			</a>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<form x-data x-bind="BulkEdit" action="/bulk/firewall/banlist/" method="post">
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
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Banned IP Addresses")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>">
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("IP Address")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Date")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Time")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Chain")) ?></div>
		</div>

		<!-- Begin banned IP address list item loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;
				$ip = $key;
			?>
			<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml( _("Select")) ?>" name="ipchain[]" value="<?= tohtml($ip . ":" . $value["CHAIN"]) ?>">
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
					</div>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("IP Address")) ?>:</span>
					<?= tohtml($ip) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-delete shrink-0" data-key-action="js">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/delete/firewall/banlist/?<?= tohtml(http_build_query(["ip" => $ip, "chain" => $value["CHAIN"], "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml( _("Delete")) ?>"
								data-confirm-title="<?= tohtml( _("Delete")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to delete IP address %s?"), $key)) ?>"
							>
								<i class="fas fa-trash icon-red text-red-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Delete")) ?></span>
							</a>
						</li>
					</ul>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Date")) ?>:</span>
					<time datetime="<?= tohtml( _($data[$key]["DATE"])) ?>"><?= tohtml( _($data[$key]["DATE"])) ?></time>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Time")) ?>:</span>
					<?= tohtml($data[$key]["TIME"]) ?>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Chain")) ?>:</span>
					<?= tohtml( _($value["CHAIN"])) ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php
				if ( $i == 0) {
					echo _('There are currently no banned IP addresses.');
				} else {
					printf(ngettext('%d banned IP address', '%d banned IP addresses', $i),$i);
				}
			?>
		</p>
	</div>

</div>
