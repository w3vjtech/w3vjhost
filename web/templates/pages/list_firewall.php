<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/server/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml(_("Back")) ?>
			</a>
			<a href="/add/firewall/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml(_("Add Rule")) ?>
			</a>
			<?php if (!empty($_SESSION["FIREWALL_EXTENSION"])): ?>
				<a class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/firewall/banlist/">
					<i class="fas fa-eye icon-red text-red-700"></i><?= tohtml(_("Banned IP Addresses")) ?>
				</a>
			<?php endif; ?>
			<a class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/firewall/ipset/">
				<i class="fas fa-list icon-blue text-blue-700"></i><?= tohtml(_("IPset IP Lists")) ?>
			</a>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<div class="toolbar-sorting relative flex min-w-0 flex-wrap items-center gap-2 text-sm">
				<button class="toolbar-sorting-toggle js-toggle-sorting-menu rounded px-2 py-1 text-slate-600 hover:bg-slate-100" type="button" title="<?= tohtml(_("Sort items")) ?>">
					<?= tohtml(_("Sort by")) ?>:
					<span class="u-text-bold font-bold">
						<?= tohtml(_("Action")) ?> <i class="fas fa-arrow-up-a-z"></i>
					</span>
				</button>
				<ul class="toolbar-sorting-menu js-sorting-menu u-hidden absolute top-full left-0 z-30 min-w-48 rounded-lg border border-slate-200 bg-white p-2 shadow-lg [&_li]:flex [&_span]:cursor-pointer [&_span]:p-2 [&_.active]:bg-blue-50">
					<li data-entity="sort-action">
						<span class="name"><?= tohtml(_("Action")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up active"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-protocol">
						<span class="name"><?= tohtml(_("Protocol")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-port">
						<span class="name"><?= tohtml(_("Port")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-ip" data-sort-as-int="1">
						<span class="name"><?= tohtml(_("IP Address")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-comment">
						<span class="name"><?= tohtml(_("Comment")) ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<form x-data x-bind="BulkEdit" action="/bulk/firewall/" method="post">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
						<option value=""><?= tohtml(_("Apply to selected")) ?></option>
						<option value="delete"><?= tohtml(_("Delete")) ?></option>
					</select>
					<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml(_("Apply to selected")) ?>">
						<i class="fas fa-arrow-right"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml(_("Firewall Rules")) ?></h1>

	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml(_("Select all")) ?>">
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Pos")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Action")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml(_("Comment")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml(_("Protocol")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml(_("Port")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml(_("IP Address")) ?></div>
		</div>

		<!-- Begin firewall chain/action list item loop -->
		<?php foreach ($data as $key => $value) {

  	++$i;
  	if ($i === 1) {
  		$move_up_enabled = false;
  		$move_down_enabled = true;
  	} elseif ($i == count($data)) {
  		$move_up_enabled = true;
  		$move_down_enabled = false;
  	} else {
  		$move_up_enabled = true;
  		$move_down_enabled = true;
  	}
  	if ($data[$key]["SUSPENDED"] == "yes") {
  		$status = "suspended";
  		$spnd_action = "unsuspend";
  		$spnd_action_title = _("Unsuspend");
  		$spnd_icon = "fa-play";
  		$spnd_icon_class = "icon-green text-green-700";
  		$spnd_confirmation = _("Are you sure you want to unsuspend rule #%s?");
  	} else {
  		$status = "active";
  		$spnd_action = "suspend";
  		$spnd_action_title = _("Suspend");
  		$spnd_icon = "fa-pause";
  		$spnd_icon_class = "icon-highlight text-slate-700";
  		$spnd_confirmation = _("Are you sure you want to suspend rule #%s?");
  	}
  	?>
			<div class="units-table-row <?php if ($status == "suspended") {
   	echo "disabled";
   } ?> js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500"
				data-sort-action="<?= tohtml($data[$key]["ACTION"]) ?>"
				data-sort-protocol="<?= tohtml($data[$key]["PROTOCOL"]) ?>"
				data-sort-port="<?= tohtml($data[$key]["PORT"]) ?>"
				data-sort-ip="<?= tohtml(str_replace(".", "", $data[$key]["IP"])) ?>"
				data-sort-comment="<?= tohtml($data[$key]["COMMENT"]) ?>">
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<div>
						<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" title="<?= tohtml(_("Select")) ?>" name="rule[]" value="<?= tohtml($key) ?>">
						<label for="check<?= tohtml($i) ?>" class="u-hide-desktop xl:hidden!"><?= tohtml(_("Select")) ?></label>
					</div>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Position")) ?>:</span>
					<a href="/edit/firewall/?<?= tohtml(http_build_query(["rule" => $key, "token" => $_SESSION["token"]])) ?>" title="<?= tohtml(_("Edit Firewall Rule")) ?>">
						<?php $rule = $key; ?>
						<?= tohtml($rule) ?>
					</a>
				</div>
				<div class="units-table-cell min-w-0 px-0 py-1 wrap-anywhere xl:table-cell xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-up shrink-0" data-key-action="js">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								style="<?= tohtml($move_up_enabled ? "display:block!important" : "display:none!important") ?>"
								href="/move/firewall/?<?= tohtml(http_build_query(["rule" => $key, "direction" => "up", "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml(_("Move Firewall Rule Up")) ?>"
								data-confirm-title="<?= tohtml(_("Move Up")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to move rule #%s up?"), $key)) ?>">
								<i class="fas fa-arrow-up icon-blue text-blue-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Move Firewall Rule Up")) ?></span>
							</a>
						</li>
						<li class="units-table-row-action shortcut-down shrink-0" data-key-action="js">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								style="<?= tohtml($move_down_enabled ? "display:block!important" : "display:none!important") ?>"
								href="/move/firewall/?<?= tohtml(http_build_query(["rule" => $key, "direction" => "down", "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml(_("Move Firewall Rule Down")) ?>"
								data-confirm-title="<?= tohtml(_("Move Down")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to move rule #%s down?"), $key)) ?>">
								<i class="fas fa-arrow-down icon-blue text-blue-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Move Firewall Rule Down")) ?></span>
							</a>
						</li>
					</ul>
				</div>
				<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Action")) ?>:</span>
					<a href="/edit/firewall/?<?= tohtml(http_build_query(["rule" => $key, "token" => $_SESSION["token"]])) ?>" title="<?= tohtml(_("Edit Firewall Rule")) ?>">
						<?php
      $suspended = $data[$key]["SUSPENDED"] == "no";
      $action = $data[$key]["ACTION"];
      $iconClass = $action == "DROP" ? "fa-circle-minus" : "fa-circle-check";
      $colorClass = $action == "DROP" ? "icon-red text-red-700" : "icon-green text-green-700";
      ?>
						<i class="fas <?= tohtml($iconClass) ?> u-mr5 <?= tohtml($suspended ? $colorClass : "") ?> mr-[5px]"></i> <?= tohtml($action) ?>
					</a>
				</div>
				<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
					<ul class="units-table-row-actions flex flex-wrap items-center gap-1">
						<li class="units-table-row-action shortcut-enter shrink-0" data-key-action="href">
							<a
								class="units-table-row-action-link inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/edit/firewall/?<?= tohtml(http_build_query(["rule" => $key, "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml(_("Edit Firewall Rule")) ?>"
							>
								<i class="fas fa-pencil icon-orange text-amber-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Edit Firewall Rule")) ?></span>
							</a>
						</li>
						<li class="units-table-row-action shortcut-s shrink-0" data-key-action="js">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/<?= tohtml($spnd_action) ?>/firewall/?<?= tohtml(http_build_query(["rule" => $key, "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml($spnd_action_title) ?>"
								data-confirm-title="<?= tohtml($spnd_action_title) ?>"
								data-confirm-message="<?= tohtml(sprintf($spnd_confirmation, $key)) ?>"
							>
								<i class="fas <?= tohtml($spnd_icon) ?> <?= tohtml($spnd_icon_class) ?>"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml($spnd_action_title) ?></span>
							</a>
						</li>
						<li class="units-table-row-action shortcut-delete shrink-0" data-key-action="js">
							<a
								class="units-table-row-action-link data-controls js-confirm-action inline-flex min-h-8 min-w-8 items-center gap-2 rounded-md px-2 py-1 text-slate-600 hover:bg-slate-100"
								href="/delete/firewall/?<?= tohtml(http_build_query(["rule" => $key, "token" => $_SESSION["token"]])) ?>"
								title="<?= tohtml(_("Delete")) ?>"
								data-confirm-title="<?= tohtml(_("Delete")) ?>"
								data-confirm-message="<?= tohtml(sprintf(_("Are you sure you want to delete rule #%s?"), $key)) ?>"
							>
								<i class="fas fa-trash icon-red text-red-700"></i>
								<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Delete")) ?></span>
							</a>
						</li>
					</ul>
				</div>
				<div class="units-table-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Comment")) ?>:</span>
					<?php if (!empty($data[$key]["COMMENT"])) {
     	echo tohtml($data[$key]["COMMENT"]);
     } ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml(_("Protocol")) ?>:</span>
					<?= tohtml(_($data[$key]["PROTOCOL"])) ?>
				</div>
				<div class="units-table-cell u-text-bold u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-bold xl:text-center">
					<span class="u-hide-desktop xl:hidden!"><?= tohtml(_("Port")) ?>:</span>
					<?= tohtml($data[$key]["PORT"]) ?>
				</div>
				<div class="units-table-cell u-text-center-desktop min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle xl:text-center">
					<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml(_("IP Address")) ?>:</span>
					<?= tohtml($data[$key]["IP"]) ?>
				</div>
			</div>
		<?php
  } ?>
	</div>

	<div class="units-table-footer py-4 text-sm text-slate-500">
		<p>
			<?php printf(ngettext("%d firewall rule", "%d firewall rules", $i), $i); ?>
		</p>
	</div>

</div>
