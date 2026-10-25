<?php
use function Hestiacp\quoteshellarg\quoteshellarg;

ob_start();
$TAB = "DB";
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

if (empty($_POST["ok"]) || $read_only === true) {
	header("Location: /list/db/");
	exit();
}
verify_csrf($_POST);

$type = $_POST["type"] ?? "";
$name = $_POST["name"] ?? "";
if (!in_array($type, ["mongodb", "redis"], true) || !preg_match('/^[a-z][a-z0-9_]{0,31}$/', $name)) {
	$_SESSION["error_msg"] = _("Invalid NoSQL database.");
	header("Location: /list/db/");
	exit();
}

exec(
	HESTIA_CMD .
		"v-reset-nosql-database-password " .
		$user .
		" " .
		quoteshellarg($type) .
		" " .
		quoteshellarg($name),
	$output,
	$return_var,
);
check_return_code($return_var, $output);
$password = trim(implode("", $output));
unset($output);
if (!preg_match('/^[A-Za-z0-9]{32}$/', $password)) {
	$_SESSION["error_msg"] = _("The password was reset, but its one-time value could not be displayed. Reset it again to obtain a new one.");
} else {
	$_SESSION["nosql_credential"] = [
		"type" => $type,
		"name" => $name,
		"password" => $password,
	];
	$_SESSION["ok_msg"] = _("NoSQL database password has been reset.");
}

http_response_code(303);
header("Location: /list/db/");
exit();
