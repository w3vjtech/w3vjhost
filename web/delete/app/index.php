<?php
use function Hestiacp\quoteshellarg\quoteshellarg;

ob_start();
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

// Check token
verify_csrf($_GET);

if ($read_only === true) {
	header("Location: /list/app/");
	exit();
}

// Removes the app only: the code in the app folder is kept and the domain goes back to PHP
if (!empty($_GET["domain"])) {
	$v_domain = quoteshellarg($_GET["domain"]);
	exec(HESTIA_CMD . "v-delete-web-domain-app " . $user . " " . $v_domain, $output, $return_var);
	check_return_code($return_var, $output);
	unset($output);
}

header("Location: /list/app/");
exit();
