<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a href="/edit/server/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-gear icon-maroon text-pink-700"></i><?= tohtml( _("Configure")) ?>
			</a>
			<a href="/list/rrd/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-chart-area icon-blue text-blue-700"></i><?= tohtml( _("Task Monitor")) ?>
			</a>
			<a href="/list/updates/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-arrows-rotate icon-green text-green-700"></i><?= tohtml( _("Updates")) ?>
			</a>
			<?php if (!empty($_SESSION["FIREWALL_SYSTEM"]) && $_SESSION["FIREWALL_SYSTEM"] == "iptables") { ?>
				<a href="/list/firewall/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-shield-halved icon-red text-red-700"></i><?= tohtml( _("Firewall")) ?>
				</a>
			<?php } ?>
			<a href="/list/log/?<?= tohtml(http_build_query(["user" => 'system', "token" => $_SESSION["token"]])) ?>" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-binoculars icon-orange text-amber-700"></i><?= tohtml( _("Logs")) ?>
			</a>
			<a
				class="button button-secondary button-danger data-controls js-confirm-action inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50! border-red-200! text-red-700! hover:bg-red-50!"
				href="/restart/system/?<?= tohtml(http_build_query(["hostname" => $sys["sysinfo"]["HOSTNAME"], "token" => $_SESSION["token"], "system_reset_token" => time()])) ?>"
				data-confirm-title="<?= tohtml( _("Restart")) ?>"
				data-confirm-message="<?= tohtml( _("Are you sure you want to restart the server?")) ?>"
			>
				<i class="fas fa-arrow-rotate-left icon-red text-red-700"></i><?= tohtml( _("Restart")) ?>
			</a>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<form x-data x-bind="BulkEdit" action="/bulk/service/" method="post">
				<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
					<option value=""><?= tohtml( _("Apply to selected")) ?></option>
					<option value="stop"><?= tohtml( _("Stop")) ?></option>
					<option value="start"><?= tohtml( _("Start")) ?></option>
					<option value="restart"><?= tohtml( _("Restart")) ?></option>
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

	<div class="server-summary flex flex-wrap items-start gap-6 py-5">
		<div class="server-summary-icon text-4xl text-blue-700">
			<i class="fas fa-server"></i>
		</div>
		<div class="server-summary-content min-w-0 flex-1">
			<h1 class="server-summary-title text-xl font-semibold"><?= tohtml($sys["sysinfo"]["HOSTNAME"]) ?></h1>
			<ul class="server-summary-list mt-3 grid gap-4 sm:grid-cols-3">
				<li class="server-summary-item">
					<span class="server-summary-list-label block font-semibold"><?= tohtml($_SESSION["APP_NAME"]) ?></span>
					<span class="server-summary-list-value">
						<?php if ($sys["sysinfo"]["RELEASE"] == "release") { ?>
							<i class="fas fa-cube" title="<?= tohtml( _("Production Release")) ?>"></i>
						<?php } else { ?>
							<i class="fas fa-flask icon-red text-red-700" title="<?= tohtml($sys["sysinfo"]["RELEASE"]) ?>"></i>
						<?php } ?>
						v<?= tohtml($sys["sysinfo"]["HESTIA"]) ?>
					</span>
				</li>
				<li class="server-summary-item">
					<span class="server-summary-list-label block font-semibold"><?= tohtml( _("Operating System")) ?></span>
					<span class="server-summary-list-value">
						<?= tohtml($sys["sysinfo"]["OS"]) ?> <?= tohtml($sys["sysinfo"]["VERSION"]) ?> (<?= tohtml($sys["sysinfo"]["ARCH"]) ?>)
					</span>
				</li>
				<li class="server-summary-item">
					<span class="server-summary-list-label block font-semibold"><?= tohtml( _("Load Average")) ?> <span class="hint text-sm leading-6 text-slate-500">(1m / 5m / 15m)</span></span>
					<span class="server-summary-list-value">
						<?= tohtml($sys["sysinfo"]["LOADAVERAGE"]) ?>
					</span>
				</li>
				<li class="server-summary-item">
					<span class="server-summary-list-label block font-semibold"><?= tohtml( _("Uptime")) ?></span>
					<span class="server-summary-list-value">
						<?= tohtml(humanize_time($sys["sysinfo"]["UPTIME"])) ?>
					</span>
				</li>
			</ul>
		</div>
	</div>

	<h1 class="u-text-center u-hide-desktop u-pr30 u-mb20 u-pl30 text-center xl:hidden! pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Services")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>">
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Service")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Description")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Uptime")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("CPU")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Memory")) ?></div>
		</div>

		<!-- Begin services status list item loop -->
		<?php
			foreach ($data as $key => $value) {
			++$i;
				if ($data[$key]['STATE'] == 'running') {
					$status = 'active';
					$action = 'stop';
					$action_text = _('Stop');
					$spnd_icon = 'fa-stop';
					$spnd_icon_class = 'icon-red text-red-700';
					$state_icon = 'fa-circle-check icon-green text-green-700';
				} else {
					$status = 'suspended';
					$action = 'start';
					$action_text = _('Start');
					$spnd_icon = 'fa-play';
					$spnd_icon_class = 'icon-green text-green-700';
					$state_icon = 'fa-circle-minus icon-red text-red-700';
				}
				if (in_array($key, $phpfpm)){
					$edit_url="php";
				} else {
					$edit_url=$key;
				}

				$cpu = $data[$key]['CPU'] / 10;
				$cpu = number_format($cpu, 1);
				if ($cpu == '0.0')	$cpu = 0;
			?>
			<div class="units-table-row <?php if ($status == 'suspended') echo 'disabled'; ?> js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-sort-name="<?= tohtml(strtolower($key)) ?>"
				data-sort-memory="<?= tohtml($data[$key]["MEM"]) ?>"
				data-sort-cpu="<?= tohtml($cpu) ?>"
				data-sort-uptime="<?= tohtml($data[$key]["RTIME"]) ?>">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml( _("Select")) ?>" name="service[]" value="<?= tohtml($key) ?>">
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml( _("Select")) ?></label>
					</div>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Service")) ?>:</span>
					<i class="fas <?= tohtml($state_icon) ?> u-mr5 mr-[5px]"></i>
					<a href="/edit/server/<? echo $edit_url ?>/" title="<?= tohtml( _("Edit")) ?>: <?= tohtml($key) ?>">
						<?= tohtml($key) ?>
					</a>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/edit/server/<? echo $edit_url ?>/"
								title="<?= tohtml( _("Edit")) ?>"
							>
								<i class="fas fa-pencil icon-orange text-amber-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Edit")) ?></span>
							</a>
						</li>
						<li class="units-table-row-action shortcut-s shrink-0" data-key-action="js">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/restart/service/?<?= tohtml(http_build_query(["srv" => $key, "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml( _("Restart")) ?>"
								data-confirm-title="<?= tohtml( _("Restart")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to restart the %s service?"), $key)) ?>"
							>
								<i class="fas fa-arrow-rotate-left icon-highlight text-slate-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Restart")) ?></span>
							</a>
						</li>
						<li class="units-table-row-action shortcut-delete shrink-0" data-key-action="js">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/<?= tohtml($action) ?>/service/?<?= tohtml(http_build_query(["srv" => $key, "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml($action_text) ?>"
								data-confirm-title="<?= tohtml($action_text) ?>"
								data-confirm-message="<?php if ($action == 'stop') { echo sprintf(_('Are you sure you want to stop the %s service?'), $key); } else { echo sprintf(_('Are you sure you want to start the %s service?'), $key); }?>"
							>
								<i class="fas <?= tohtml($spnd_icon) ?> <?= tohtml($spnd_icon_class) ?>"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml($action_text) ?></span>
							</a>
						</li>
					</ul>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Description")) ?>:</span>
					<?= tohtml( _($data[$key]["SYSTEM"])) ?>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Uptime")) ?>:</span>
					<?= tohtml(humanize_time($data[$key]["RTIME"])) ?>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("CPU")) ?>:</span>
					<?= tohtml($cpu) ?>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml( _("Memory")) ?>:</span>
					<?= tohtml($data[$key]["MEM"]) ?> <?= tohtml( _("MB")) ?>
				</div>
			</div>
		<?php } ?>
	</div>

</div>
