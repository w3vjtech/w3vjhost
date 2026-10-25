<script defer src="https://cdn.jsdelivr.net/npm/lucide@1.61.0/dist/umd/lucide.min.js" integrity="sha384-wx1iBc8a89SnsJAxZPb9eNEoMn4t/Wg111+QJyasxB9Om4SDDtkJeBuXx4NiRwa8" crossorigin="anonymous"></script>
<script defer src="/js/ui-sidebar.js?v=<?= filemtime(__DIR__ . "/../../js/ui-sidebar.js") ?>"></script>
<script defer src="/js/dist/main.min.js?<?= JS_LATEST_UPDATE ?>"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.17.5/dist/cdn.min.js" integrity="sha384-NArNwzWsUSF+kY2lgW4YriEkjLqi+J+za6HrENUn/3nZqkBnWbxV22kCJEK5Uu6n" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.17.5/dist/cdn.min.js" integrity="sha384-FYLKjwG3aohNhNZoVG8sY/5ntunm+MqylL90Q+rT3OM7AwV9/BKFjk/RjoIpIgsI" crossorigin="anonymous"></script>
<script>
	document.documentElement.classList.replace('no-js', 'js');
	document.addEventListener('alpine:init', () => {
		Alpine.store('globals', {
			USER_PREFIX: '<?= $user_plain ?>_',
			UNLIMITED: '<?= _("Unlimited") ?>',
			NOTIFICATIONS_EMPTY: '<?= _("No notifications") ?>',
			NOTIFICATIONS_DELETE_ALL: '<?= _("Delete all notifications") ?>',
			CONFIRM_LEAVE_PAGE: '<?= _("Are you sure you want to leave the page?") ?>',
			ERROR_MESSAGE: '<?= !empty($_SESSION["error_msg"]) ? htmlentities($_SESSION["error_msg"],ENT_QUOTES) : "" ?>',
			BLACKLIST: '<?= _("BLACKLIST") ?>',
			IPVERSE: '<?= _("IPVERSE") ?>'
		});
	})
</script>
<?php $_SESSION["unset_alerts"] = true; ?>

<?php
$customScriptDirectory = new DirectoryIterator($_SERVER["HESTIA"] . "/web/js/custom_scripts");
foreach ($customScriptDirectory as $customScript) {
	$extension = $customScript->getExtension();
	if ($extension === "js") {
		$customScriptPath = "/js/custom_scripts/" . rawurlencode($customScript->getBasename()) . "?v=" . $customScript->getMTime();
		echo '<script defer src="' . $customScriptPath . '"></script>';
	} elseif ($extension === "php") {
		require_once $customScript->getPathname();
	}
} ?>
