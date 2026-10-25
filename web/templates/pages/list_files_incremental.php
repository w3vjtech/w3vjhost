<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true) { ?>
			<?php if(str_starts_with($files[0]['path'],'/home/'.$user_plain) && $files[0]['path'] != '/home/'.$user_plain ){
			?>
			<a class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" id="btn-back" href="/list/backup/incremental/?<?= tohtml(http_build_query(["snapshot" => $_GET["snapshot"], "browse" => "yes", "folder" => $files[0]["path"] . "/../", "token" => $_SESSION["token"]])) ?>"><i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?></a>
			<?php }else{
			?>
			<a class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" id="btn-back" href="/list/backup/incremental/?<?= tohtml(http_build_query(["token" => $_SESSION["token"]])) ?>"><i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?></a>
			<?php
			}
			?>
			<?php } ?>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
					<?php if ($read_only !== true) { ?>
						<form x-data x-bind="BulkEdit" action="/bulk/restore/" method="post">
							<input type="hidden" name="backup" value="<?= tohtml($_GET["snapshot"]) ?>">
							<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="action">
							<option value=""><?= tohtml( _("Apply to selected")) ?></option>
							<option value="delete"><?= tohtml( _("Restore Files")) ?></option>
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
	<h1 class="u-text-center u-hide-desktop u-mt20 u-pr30 u-mb20 u-pl30 text-center xl:hidden! mt-[20px] pr-[30px] mb-[20px] pl-[30px]"><?= tohtml( _("Files")) ?></h1>
	<div class="units-table js-units-container w-full text-sm xl:table xl:border-collapse">
		<div class="units-table-header hidden border-b border-slate-200 bg-slate-100 font-semibold text-slate-600 xl:table-row">
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
				<input type="checkbox" class="js-toggle-all-checkbox" title="<?= tohtml( _("Select all")) ?>" <?= tohtml($display_mode) ?>>
			</div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"><?= tohtml( _("Name")) ?></div>
			<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle"></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Type")) ?></div>
			<div class="units-table-cell u-text-center min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle text-center"><?= tohtml( _("Date")) ?></div>
		</div>
		<?php
		foreach($files as $file){
			if($file['path'] != '/home/'.$user_plain){
				if($file['path'] != '/home/'.$user_plain && $file['path'] == $files[0]['path']){
					?>
					<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						</div>
						<div class="units-table-cell units-table-heading-cell u-text-bold min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle font-semibold text-slate-800 font-bold">
								<b><a href="/list/backup/incremental/?<?= tohtml(http_build_query(["snapshot" => $_GET["snapshot"], "browse" => "yes", "folder" => $files[0]["path"] . "/../", "token" => $_SESSION["token"]])) ?>"><i class="fas fa-folder icon-dim u-mr5 text-slate-400 mr-[5px]"></i>..</a></b>
						</div>
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						</div>
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
							<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
							<span class="u-text-bold font-bold">
								Directory
							</span>
						</div>
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
						</div>
					</div>
				<?php
					}else{
				?>
					<div class="units-table-row js-unit my-3 block rounded-lg border border-slate-200 bg-white p-3 hover:bg-slate-50 focus-within:bg-blue-50 xl:table-row xl:rounded-none [&.selected]:bg-blue-50 [&.focus]:outline-2 [&.focus]:-outline-offset-2 [&.focus]:outline-blue-500 [&.disabled]:bg-slate-100 [&.disabled]:text-slate-500">
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
							<div>
								<input id="check<?= tohtml($i) ?>" class="js-unit-checkbox" type="checkbox" name="files[]" value="<?=htmlentities($file['path'])?>">
							</div>
						</div>
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
							<div>
								<?php if($file['type'] == 'dir'){
									if(str_starts_with($file['path'], '/home/'.$user_plain.'/conf')){
								?>
								<b><i class="fas fa-folder icon-dim u-mr5 text-slate-400 mr-[5px]"></i><?= tohtml($file['name']) ?></b>
								<?php
									}else{
									?>
											<b><a href="/list/backup/incremental/?<?= tohtml(http_build_query(["snapshot" => $_GET["snapshot"], "browse" => "yes", "folder" => $file["path"], "token" => $_SESSION["token"]])) ?>"><i class="fas fa-folder icon-dim u-mr5 text-slate-400 mr-[5px]"></i><?= tohtml($file['name']) ?></a></b>
									<?php
									}
								}else{
									?>
										<b><i class="fas fa-file icon-dim u-mr5 text-slate-400 mr-[5px]"></i><?= tohtml($file['name']) ?></b>
									<?php
								}?>
							</div>
						</div>
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
							<a href="/schedule/restore/incremental/?<?= tohtml(http_build_query(["snapshot" => $_GET["snapshot"], "type" => "file", "object" => $file["path"], "token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Restore")) ?>">
								<i class="fas fa-arrow-rotate-left icon-green icon-dim u-mr5 text-green-700 text-slate-400 mr-[5px]"></i>
							</a>
						</div>
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
							<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Type")) ?>:</span>
							<span class="u-text-bold font-bold">
								<?= tohtml(getTransByType($file['type'])) ?>
							</span>
						</div>
						<div class="units-table-cell min-w-0 py-1 wrap-anywhere xl:table-cell xl:px-3 xl:py-3 xl:align-middle">
							<span class="u-hide-desktop u-text-bold xl:hidden! font-bold"><?= tohtml( _("Date / Time")) ?>:</span>
							<span class="u-text-bold font-bold">
								<?= tohtml(convert_datetime($file['ctime'], 'Y-m-d  H:i:s')) ?>
							</span>
						</div>
					</div>
				<?php
				}
			}
		} ?>
	</div>
</div>

<footer class="app-footer border-t border-slate-200 bg-white py-4 text-xs text-slate-500">
	<div class="container mx-auto w-full max-w-none px-4 md:px-6 flex flex-wrap items-center justify-between gap-3">
		<p>
			<?php printf(ngettext("%d item", "%d items", $i), $i); ?>
		</p>
	</div>
</footer>
