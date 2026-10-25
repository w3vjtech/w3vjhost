<?php
use function Hestiacp\quoteshellarg\quoteshellarg;

ob_start();
$TAB = "DB";
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

if (!empty($_POST["ok"]) && $read_only !== true) {
	verify_csrf($_POST);
	$type = $_POST["type"] ?? "";
	$name = $_POST["name"] ?? "";

	if (!in_array($type, ["mongodb", "redis"], true)) {
		$_SESSION["error_msg"] = _("Please select an installed NoSQL service.");
	} elseif (!preg_match('/^[a-z][a-z0-9_]{0,31}$/', $name)) {
		$_SESSION["error_msg"] = _("Use a lowercase name starting with a letter; letters, numbers, and underscores only.");
	}

	if (empty($_SESSION["error_msg"])) {
		exec(
			HESTIA_CMD .
				"v-add-nosql-database " .
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
			$_SESSION["error_msg"] = _("The database was created, but its one-time password could not be displayed. Reset the password to obtain a new one.");
		} else {
			$_SESSION["nosql_credential"] = [
				"type" => $type,
				"name" => $name,
				"password" => $password,
			];
			http_response_code(303);
			header("Location: /list/db/");
			exit();
		}
	}
}

exec(HESTIA_CMD . "v-list-nosql-databases $user json", $output, $return_var);
check_return_code($return_var, $output);
$nosql_data = json_decode(implode("", $output), true);
if (!is_array($nosql_data)) {
	$_SESSION["error_msg"] = _("Unable to load NoSQL database information.");
	$nosql_data = ["services" => ["mongodb" => false, "redis" => false]];
}
unset($output);

render_page($user, $TAB, "add_nosql");
unset($_SESSION["error_msg"]);
unset($_SESSION["ok_msg"]);
