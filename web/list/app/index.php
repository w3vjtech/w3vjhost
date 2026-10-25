<?php
use function Hestiacp\quoteshellarg\quoteshellarg;

$TAB = "APP";

// Main include
include $_SERVER["DOCUMENT_ROOT"] . "/inc/main.php";

// Web domains of the user; the ones with APP_TEMPLATE run an application
exec(HESTIA_CMD . "v-list-web-domains " . $user . " 'json'", $output, $return_var);
$domains = json_decode(implode("", $output), true) ?? [];
unset($output);

$data = [];
$free_domains = 0;
foreach ($domains as $domain => $domain_data) {
	if (empty($domain_data["APP_TEMPLATE"])) {
		if ($domain_data["SUSPENDED"] !== "yes") {
			$free_domains++;
		}
		continue;
	}
	exec(
		HESTIA_CMD . "v-list-web-domain-app " . $user . " " . quoteshellarg($domain) . " json",
		$output,
		$return_var,
	);
	$app = json_decode(implode("", $output), true);
	unset($output);
	$data[$domain] = array_merge($domain_data, $app[$domain] ?? []);
}
ksort($data);

// Render page
render_page($user, $TAB, "list_app");

// Back uri
$_SESSION["back"] = $_SERVER["REQUEST_URI"];
