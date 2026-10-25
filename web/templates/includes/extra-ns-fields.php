<?php
	$nsValues = ['v_ns3', 'v_ns4', 'v_ns5', 'v_ns6', 'v_ns7', 'v_ns8'];
	foreach ($nsValues as $nsValue) {
		if ($$nsValue) {
			?>
			<div class="u-side-by-side u-mb5 flex flex-wrap items-center gap-2 mb-[5px]">
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="<?php echo $nsValue; ?>" value="<?php echo htmlentities(trim($$nsValue, "'")); ?>">
				<button type="button" class="u-button-reset u-ml10 js-remove-ns border-0 bg-transparent p-0 ml-[10px]" title="<?= _("Remove") ?>">
					<i class="fas fa-trash icon-dim icon-red text-slate-400 text-red-700"></i>
				</button>
			</div>
			<?php
		}
	}
?>
