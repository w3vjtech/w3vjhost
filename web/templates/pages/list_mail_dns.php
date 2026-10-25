<?php
$v_webmail_alias = "webmail";
if (!empty($_SESSION["WEBMAIL_ALIAS"])) {
	$v_webmail_alias = $_SESSION["WEBMAIL_ALIAS"];
}
?>
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/mail/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0"></div>
	</div>
</div>

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("DNS Records")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Record")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Type")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Priority")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("TTL")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("IP or Value")) ?></div>
		</div>

		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Record")) ?>:</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="mail.<?= tohtml($_GET["domain"]) ?>">
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Type")) ?>:</span>
				A
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Priority")) ?>:</span>
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("TTL")) ?>:</span>
				14400
			</div>
			<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IP or Value")) ?>:</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml(empty($ips[array_key_first($ips)]["NAT"]) ? array_key_first($ips) : $ips[array_key_first($ips)]["NAT"]) ?>">
			</div>
		</div>
		<?php if ($_SESSION["WEBMAIL_SYSTEM"]) { ?>
			<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Record")) ?>:</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($v_webmail_alias) ?>.<?= tohtml($_GET["domain"]) ?>">
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Type")) ?>:</span>
					A
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Priority")) ?>:</span>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("TTL")) ?>:</span>
					14400
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IP or Value")) ?>:</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml(empty($ips[array_key_first($ips)]["NAT"]) ? array_key_first($ips) : $ips[array_key_first($ips)]["NAT"]) ?>">
				</div>
			</div>
		<?php } ?>
		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Record")) ?>:</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($_GET["domain"]) ?>">
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Type")) ?>:</span>
				MX
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Priority")) ?>:</span>
				10
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("TTL")) ?>:</span>
				14400
			</div>
			<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IP or Value")) ?>:</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="mail.<?= tohtml($_GET["domain"]) ?>.">
			</div>
		</div>
		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Record")) ?>:</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($_GET["domain"]) ?>">
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Type")) ?>:</span>
				TXT
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Priority")) ?>:</span>
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("TTL")) ?>:</span>
				14400
			</div>
			<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IP or Value")) ?>:</label>
				<?php $ip = empty($ips[array_key_first($ips)]["NAT"]) ? array_key_first($ips) : $ips[array_key_first($ips)]["NAT"]; ?>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml("v=spf1 a mx ip4:" . $ip . " -all") ?>">
			</div>
		</div>
		<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Record")) ?>:</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="_dmarc">
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Type")) ?>:</span>
				TXT
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Priority")) ?>:</span>
			</div>
			<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
				<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("TTL")) ?>:</span>
				14400
			</div>
			<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
				<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IP or Value")) ?>:</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml("v=DMARC1; p=quarantine; pct=100") ?>">
			</div>
		</div>
		<?php foreach ($dkim as $key => $value) { ?>
			<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Record")) ?>:</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($key) ?>">
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Type")) ?>:</span>
					TXT
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Priority")) ?>:</span>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("TTL")) ?>:</span>
					3600
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<label class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("IP or Value")) ?>:</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml(str_replace(['"', "'"], "", $dkim[$key]["TXT"])) ?>">
				</div>
			</div>
		<?php } ?>
	</div>

</div>
