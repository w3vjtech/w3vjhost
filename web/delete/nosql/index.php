<?php
use function Hestiacp\quoteshellarg\quoteshellarg;

ob_start();
$TAB = "DB";
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

verify_csrf($_GET);
if ($read_only === true) {
	header("Location: /list/db/");
	exit();
}

$type = $_GET["type"] ?? "";
$name = $_GET["name"] ?? "";
if (!in_array($type, ["mongodb", "redis"], true) || !preg_match('/^[a-z][a-z0-9_]{0,31}$/', $name)) {
	$_SESSION["error_msg"] = _("Invalid NoSQL database.");
	header("Location: /list/db/");
	exit();
}

exec(
	HESTIA_CMD .
		"v-delete-nosql-database " .
		$user .
		" " .
		quoteshellarg($type) .
		" " .
		quoteshellarg($name),
	$output,
	$return_var,
);
check_return_code($return_var, $output);
unset($output);
$_SESSION["ok_msg"] = _("NoSQL database has been deleted.");
header("Location: /list/db/");
exit();
