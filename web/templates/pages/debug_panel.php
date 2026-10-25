<?php
if( !defined("HESTIA_DIR_BIN") ){
	die("Direct access disabled");
}
?>
<div x-data="{ open: false }" class="debug-panel fixed bottom-0 left-0 z-30 w-full shadow-[0_0_5px_rgb(0_0_0/40%)] md:w-auto">
		<button
			type="button"
			class="debug-panel-toggle block w-full border-0 bg-yellow-300 px-[15px] py-[10px] text-center text-[0.8rem] font-medium text-black hover:bg-yellow-400"
			x-on:click="open = !open"
			x-text="open ? <?= tohtml(json_encode(_("Close debug panel"), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR)) ?> : <?= tohtml(json_encode(_("Open debug panel"), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR)) ?>">
			<?= tohtml( _("Open debug panel")) ?>
		</button>
	<div x-cloak x-show="open" class="debug-panel-content max-h-[300px] overflow-auto bg-slate-100 p-5 text-xs wrap-anywhere">
		<?php
			echo "<h3 class=\"u-mb10 mb-[10px] font-semibold\">Server Variables</h3>";
			foreach ($_SERVER as $key => $val) {
				if(is_string($val)){
					echo "<span class=\"u-text-bold font-bold\">" . tohtml($key) . "= </span> " . tohtml($val) . " ";
				}
			}
  	?>
		<?php
			echo "<h3 class=\"u-mb10 u-mt10 mt-[10px] mb-[10px] font-semibold\">Session Variables</h3>";
			foreach ($_SESSION as $key => $val) {
				if(is_string($val)){
					echo "<span class=\"u-text-bold font-bold\">" . tohtml($key) . "= </span> " . tohtml($val) . " ";
				}else if(is_array($val)){
					array_walk_recursive($val, function (&$value) {
							$value = htmlentities($value);
					});
					echo "<span class=\"u-text-bold font-bold\">" . tohtml($key) . "= </span> "  .tohtml(var_export($val, true)). " ";
				}
			}
  	?>
		<?php
			echo "<h3 class=\"u-mb10 u-mt10 mt-[10px] mb-[10px] font-semibold\">POST Variables</h3>";
			foreach ($_POST as $key => $val) {
				if(is_string($val)){
					echo "<span class=\"u-text-bold font-bold\">" . tohtml($key) . "= </span> " . tohtml($val) . " ";
				}else if(is_array($val)){
					array_walk_recursive($val, function (&$value) {
							$value = htmlentities($value);
					});
					echo "<span class=\"u-text-bold font-bold\">" . tohtml($key) . "= </span> "  .tohtml(var_export($val, true)). " ";
				}
			}
  	?>
		<?php
			echo "<h3 class=\"u-mb10 u-mt10 mt-[10px] mb-[10px] font-semibold\">GET Variables</h3>";
			foreach ($_GET as $key => $val) {
				if(is_string($val)){
					echo "<span class=\"u-text-bold font-bold\">" . tohtml($key) . "= </span> " . tohtml($val) . " ";
				}else if(is_array($val)){
					array_walk_recursive($val, function (&$value) {
							$value = htmlentities($value);
					});
					echo "<span class=\"u-text-bold font-bold\">" . tohtml($key) . "= </span> "  .tohtml(var_export($val, true)). " ";
				}
			}
  	?>
	</div>
</div>
