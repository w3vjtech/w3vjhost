<?php
use function Hestiacp\quoteshellarg\quoteshellarg;

ob_start();
$TAB = "APP";

// Main include
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

// Domains that can get an application: active and not running one yet
exec(HESTIA_CMD . "v-list-web-domains " . $user . " 'json'", $output, $return_var);
$domains = json_decode(implode("", $output), true) ?? [];
unset($output);
$v_domains = [];
foreach ($domains as $domain => $domain_data) {
	if (empty($domain_data["APP_TEMPLATE"]) && $domain_data["SUSPENDED"] !== "yes") {
		$v_domains[] = $domain;
	}
}

// Installed runtimes (NODE-xx, PY-x_y)
exec(HESTIA_CMD . "v-list-web-templates-app json", $output, $return_var);
$v_templates = json_decode(implode("", $output), true) ?? [];
unset($output);

$v_domain = $_GET["domain"] ?? "";
$v_template = "";
$v_entry = "";

// Check POST request
if (!empty($_POST["ok"]) && $read_only !== true) {
	// Check token
	verify_csrf($_POST);

	$v_domain = $_POST["v_domain"] ?? "";
	$v_template = $_POST["v_template"] ?? "";
	$v_entry = trim($_POST["v_entry"] ?? "");

	if (!in_array($v_domain, $v_domains, true)) {
		$_SESSION["error_msg"] = _("Please choose one of your domains without an application.");
	} elseif (!in_array($v_template, $v_templates, true)) {
		$_SESSION["error_msg"] = _("Please choose an installed runtime.");
	} elseif ($v_entry === "") {
		$_SESSION["error_msg"] = sprintf(_('Field "%s" can not be blank.'), _("Entry"));
	}

	// Add application (all values are validated again by v-add-web-domain-app)
	if (empty($_SESSION["error_msg"])) {
		exec(
			HESTIA_CMD .
				"v-add-web-domain-app " .
				$user .
				" " .
				quoteshellarg($v_domain) .
				" " .
				quoteshellarg($v_template) .
				" " .
				quoteshellarg($v_entry),
			$output,
			$return_var,
		);
		check_return_code($return_var, $output);
		$message = implode(" ", $output);
		unset($output);
	}

	if (empty($_SESSION["error_msg"])) {
		$_SESSION["ok_msg"] =
			htmlify_trans(
				sprintf(_("Application for {%s} has been created."), htmlentities($v_domain)),
				"</a>",
				'<a href="/edit/app/?domain=' . htmlentities($v_domain) . '">',
			) .
			" " .
			htmlentities($message);
		header("Location: /list/app/");
		exit();
	}
}

// Render page
render_page($user, $TAB, "add_app");

// Flush session messages
unset($_SESSION["error_msg"]);
unset($_SESSION["ok_msg"]);
