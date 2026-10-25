<?php
use function Hestiacp\quoteshellarg\quoteshellarg;

ob_start();
$TAB = "APP";

// Main include
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

// Check domain argument
if (empty($_GET["domain"])) {
	header("Location: /list/app/");
	exit();
}
$v_domain = $_GET["domain"];

// Application of the domain (v-list-web-domain-app also checks the domain belongs to $user)
exec(
	HESTIA_CMD . "v-list-web-domain-app " . $user . " " . quoteshellarg($v_domain) . " json",
	$output,
	$return_var,
);
check_return_code_redirect($return_var, $output, "/list/app/");
$app = json_decode(implode("", $output), true)[$v_domain] ?? [];
unset($output);

$v_template = $app["TEMPLATE"] ?? "";
$v_entry = $app["ENTRY"] ?? "";

// Installed runtimes
exec(HESTIA_CMD . "v-list-web-templates-app json", $output, $return_var);
$v_templates = json_decode(implode("", $output), true) ?? [];
unset($output);

// Check POST request
if (!empty($_POST["save"]) && $read_only !== true) {
	// Check token
	verify_csrf($_POST);

	$new_template = $_POST["v_template"] ?? "";
	$new_entry = trim($_POST["v_entry"] ?? "");

	// Change runtime and/or entry
	if ($new_template !== $v_template || $new_entry !== $v_entry) {
		if (!in_array($new_template, $v_templates, true)) {
			$_SESSION["error_msg"] = _("Please choose an installed runtime.");
		} elseif ($new_entry === "") {
			$_SESSION["error_msg"] = sprintf(_('Field "%s" can not be blank.'), _("Entry"));
		} else {
			exec(
				HESTIA_CMD .
					"v-change-web-domain-app-tpl " .
					$user .
					" " .
					quoteshellarg($v_domain) .
					" " .
					quoteshellarg($new_template) .
					" " .
					quoteshellarg($new_entry),
				$output,
				$return_var,
			);
			check_return_code($return_var, $output);
			unset($output);
		}
	}

	// Reinstall dependencies (npm ci / pip install -r requirements.txt, as the user)
	if (empty($_SESSION["error_msg"]) && !empty($_POST["v_deps"])) {
		exec(
			HESTIA_CMD . "v-update-web-domain-app-deps " . $user . " " . quoteshellarg($v_domain),
			$output,
			$return_var,
		);
		check_return_code($return_var, $output);
		unset($output);
	}

	if (empty($_SESSION["error_msg"])) {
		$_SESSION["ok_msg"] = _("Changes have been saved.");
	}
	header("Location: /edit/app/?domain=" . rawurlencode($v_domain));
	exit();
}

// Render page
render_page($user, $TAB, "edit_app");

// Flush session messages
unset($_SESSION["error_msg"]);
unset($_SESSION["ok_msg"]);
