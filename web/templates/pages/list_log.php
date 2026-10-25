<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($_SESSION["userContext"] === "admin") { ?>
				<a href="/list/user/" class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
				</a>
			<?php } elseif ($_SESSION["userContext"] === "admin" && htmlentities($_GET["user"]) === "system") { ?>
				<a href="/list/server/" class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
				</a>
			<?php } else { ?>
					<a href="/edit/user/?<?= tohtml(http_build_query(["token" => $_SESSION["token"]])) ?>" class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
						<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
					</a>
			<?php } ?>
			<?php if ($_SESSION['DEMO_MODE'] != "yes") { ?>
				<a href="/list/log/auth/" class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" title="<?= tohtml( _("Login History")) ?>">
					<i class="fas fa-binoculars icon-green text-green-700"></i><?= tohtml( _("Login History")) ?>
				</a>
			<?php } ?>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a href="javascript:location.reload();" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!"><i class="fas fa-arrow-rotate-right icon-green text-green-700"></i><?= tohtml( _("Refresh")) ?></a>
			<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["look"] === $_SESSION["ROOT_USER"] && $_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] === "yes") { ?>
				<!-- Hide delete buttons-->
			<?php } else { ?>
				<?php if ($_SESSION["userContext"] === "admin" || ($_SESSION["userContext"] === "user" && $_SESSION["POLICY_USER_DELETE_LOGS"] !== "no")) { ?>
					<a
						class="button button-secondary button-danger data-controls js-confirm-action inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50! border-red-200! text-red-700! hover:bg-red-50!"
						href="/delete/log/?<?= tohtml(http_build_query(["token" => $_SESSION["token"]])) ?>"
						data-confirm-title="<?= tohtml( _("Delete")) ?>"
						data-confirm-message="<?= tohtml( _("Are you sure you want to delete the logs?")) ?>"
					>
						<i class="fas fa-circle-xmark icon-red text-red-700"></i><?= tohtml( _("Delete")) ?>
					</a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Logs")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Date")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Time")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Category")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Message")) ?></div>
		</div>

		<!-- Begin log history entry loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;

				if ($data[$key]['LEVEL'] === 'Info') {
					$level_icon = 'fa-info-circle icon-blue text-blue-700';
					$level_title = _('Information');
				}
				if ($data[$key]['LEVEL'] === 'Warning') {
					$level_icon = 'fa-triangle-exclamation icon-orange text-amber-700';
					$level_title = _('Warning');
				}
				if ($data[$key]['LEVEL'] === 'Error') {
					$level_icon = 'fa-circle-xmark icon-red text-red-700';
					$level_title = _('Error');
				}
			?>
			<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<i class="fas <?= tohtml($level_icon) ?>" title="<?= tohtml($level_title) ?>"></i>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Date")) ?>:</span>
					<time datetime="<?= tohtml($data[$key]["DATE"]) ?>" class="u-text-no-wrap whitespace-nowrap">
						<?= tohtml(translate_date($data[$key]["DATE"])) ?>
					</time>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Time")) ?>:</span>
					<time datetime="<?= tohtml($data[$key]["TIME"]) ?>">
						<?= tohtml($data[$key]["TIME"]) ?>
					</time>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Category")) ?>:</span>
					<span class="u-text-no-wrap whitespace-nowrap">
						<?= tohtml($data[$key]["CATEGORY"]) ?>
					</span>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Message")) ?>:</span>
					<?= tohtml($data[$key]["MESSAGE"]) ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d log record", "%d log records", $i), $i); ?>
		</p>
	</div>

</div>
