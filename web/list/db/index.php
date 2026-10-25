<?php
$TAB = "DB";

// Main include
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

// Data
exec(HESTIA_CMD . "v-list-databases $user json", $output, $return_var);
$data = json_decode(implode("", $output), true);
if ($_SESSION["userSortOrder"] == "name") {
	ksort($data);
} else {
	$data = array_reverse($data, true);
}
unset($output);

exec(HESTIA_CMD . "v-list-nosql-databases $user json", $output, $return_var);
check_return_code($return_var, $output);
$nosql_data = json_decode(implode("", $output), true);
if (!is_array($nosql_data)) {
	$_SESSION["error_msg"] = _("Unable to load NoSQL database information.");
	$nosql_data = ["services" => ["mongodb" => false, "redis" => false], "mongodb" => [], "redis" => []];
}
unset($output);
$nosql_credential = $_SESSION["nosql_credential"] ?? null;
unset($_SESSION["nosql_credential"]);

// Render page
render_page($user, $TAB, "list_db");

// Back uri
$_SESSION["back"] = $_SERVER["REQUEST_URI"];
