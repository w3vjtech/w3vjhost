<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true && $free_domains > 0) { ?>
				<a href="/add/app/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Add Application")) ?>
				</a>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Applications")) ?></h1>

	<?php show_alert_message($_SESSION); ?>

	<?php if (empty($data)) { ?>
		<div class="u-mt20 u-mb20 mt-[20px] mb-[20px]">
			<p><?= tohtml( _("No Node.js or Python applications yet.")) ?></p>
			<?php if ($free_domains === 0) { ?>
				<p><?= tohtml( _("Add a web domain first, then run an application on it.")) ?></p>
			<?php } ?>
		</div>
	<?php } ?>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Domain")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Runtime")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Entry")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Status")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("SSL")) ?></div>
		</div>

		<!-- Begin application list item loop -->
		<?php
		$i = 0;
		foreach ($data as $domain => $app) {
			++$i;
			$suspended = $app["SUSPENDED"] === "yes";
			$status = $app["STATUS"] ?? "stopped";
			$status_icon = ["running" => "fa-circle-check icon-green text-green-700", "failed" => "fa-circle-xmark icon-red text-red-700"][$status] ?? "fa-circle-pause icon-orange text-amber-700";
			$query = ["domain" => $domain, "token" => $_SESSION["token"]];
		?>
			<div class="units-table-row <?php if ($suspended) echo 'disabled'; ?> js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500" data-sort-name="<?= tohtml($domain) ?>">
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Domain")) ?>:</span>
					<?php if ($read_only === true || $suspended) { ?>
						<?= tohtml($domain) ?>
					<?php } else { ?>
						<a href="/edit/app/?<?= tohtml(http_build_query($query)) ?>" title="<?= tohtml( _("Edit Application")) ?>: <?= tohtml($domain) ?>">
							<?= tohtml($domain) ?>
						</a>
					<?php } ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<?php if ($read_only !== true && !$suspended) { ?>
						<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
							<li class="units-table-row-action shrink-0" data-key-action="href">
								<a class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100" href="/edit/app/?<?= tohtml(http_build_query($query)) ?>" title="<?= tohtml( _("Edit")) ?>">
									<i class="fas fa-pencil icon-orange text-amber-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit")) ?></span>
								</a>
							</li>
							<?php if ($status === "running") { ?>
								<li class="units-table-row-action shrink-0" data-key-action="js">
									<a
										class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
										href="/restart/app/?<?= tohtml(http_build_query($query)) ?>"
										title="<?= tohtml( _("Restart")) ?>"
										data-confirm-title="<?= tohtml( _("Restart")) ?>"
										data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to restart the application of %s?"), $domain)) ?>"
									>
										<i class="fas fa-arrow-rotate-left icon-highlight text-slate-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restart")) ?></span>
									</a>
								</li>
								<li class="units-table-row-action shrink-0" data-key-action="js">
									<a
										class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
										href="/stop/app/?<?= tohtml(http_build_query($query)) ?>"
										title="<?= tohtml( _("Stop")) ?>"
										data-confirm-title="<?= tohtml( _("Stop")) ?>"
										data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to stop the application of %s?"), $domain)) ?>"
									>
										<i class="fas fa-stop icon-red text-red-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Stop")) ?></span>
									</a>
								</li>
							<?php } else { ?>
								<li class="units-table-row-action shrink-0" data-key-action="js">
									<a class="units-table-row-action-link data-controls inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100" href="/start/app/?<?= tohtml(http_build_query($query)) ?>" title="<?= tohtml( _("Start")) ?>">
										<i class="fas fa-play icon-green text-green-700"></i>
										<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Start")) ?></span>
									</a>
								</li>
							<?php } ?>
							<li class="units-table-row-action shortcut-delete shrink-0" data-key-action="js">
								<a
									class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
									href="/delete/app/?<?= tohtml(http_build_query($query)) ?>"
									title="<?= tohtml( _("Delete")) ?>"
									data-confirm-title="<?= tohtml( _("Delete")) ?>"
									data-confirm-message="<?= tohtml(sprintf(_("Remove the application from %s? The code in the app folder is kept and the domain goes back to PHP."), $domain)) ?>"
								>
									<i class="fas fa-trash icon-red text-red-700"></i>
									<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Delete")) ?></span>
								</a>
							</li>
						</ul>
					<?php } ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Runtime")) ?>:</span>
					<?= tohtml(app_template_label($app["APP_TEMPLATE"])) ?>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Entry")) ?>:</span>
					<code><?= tohtml($app["APP_ENTRY"]) ?></code>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Status")) ?>:</span>
					<i class="fas <?= tohtml($status_icon) ?>" title="<?= tohtml($status) ?>"></i>
					<?= tohtml(_(ucfirst($status))) ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("SSL")) ?>:</span>
					<i class="fas <?= $app["SSL"] === "yes" ? "fa-lock icon-green text-green-700" : "fa-lock-open icon-red text-red-700" ?>"></i>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d application", "%d applications", $i), $i); ?>
		</p>
	</div>

</div>
