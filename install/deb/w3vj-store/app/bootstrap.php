<?php
// W3VJHOST Store bootstrap: autoloader, config and shared helpers.
// Lives in private/store/ (outside the web root); public_html/_bootstrap.php requires it.

declare(strict_types=1);

namespace W3vj\Store;

spl_autoload_register(function (string $class): void {
	$prefix = __NAMESPACE__ . "\\";
	if (str_starts_with($class, $prefix)) {
		$file = __DIR__ . "/" . substr($class, strlen($prefix)) . ".php";
		if (is_file($file)) {
			require $file;
		}
	}
});

function config(): Config {
	static $config = null;
	return $config ??= Config::load(__DIR__ . "/config.json");
}

function db(): \PDO {
	static $pdo = null;
	return $pdo ??= Db::connect(config());
}

function razorpay(): Razorpay {
	$rzp = config()->get("razorpay");
	return new Razorpay((string) ($rzp["key_id"] ?? ""), (string) ($rzp["key_secret"] ?? ""));
}

function hestia(): HestiaApi {
	return HestiaApi::fromConfig(config());
}

function provisioner(): Provisioner {
	return new Provisioner(db(), hestia(), new Mailer(config()), config());
}

// HTML-escape for templates
function h(mixed $value): string {
	return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

// Price in paise -> "₹1,499" (no decimals when whole rupees)
function money(int $paise): string {
	$rupees = $paise / 100;
	return "₹" . number_format($rupees, fmod($rupees, 1.0) === 0.0 ? 0 : 2);
}

function client_ip(): string {
	return (string) ($_SERVER["REMOTE_ADDR"] ?? "0.0.0.0");
}

function json_response(int $status, array $data): never {
	http_response_code($status);
	header("Content-Type: application/json; charset=utf-8");
	header("Cache-Control: no-store");
	echo json_encode($data, JSON_UNESCAPED_SLASHES);
	exit();
}
