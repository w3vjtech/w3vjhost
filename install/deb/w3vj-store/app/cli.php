<?php
// W3VJHOST Store admin CLI. Run through the root wrapper: v-w3vj-store COMMAND [ARGS]
// (it runs this file as the store owner, never as root).

declare(strict_types=1);

namespace W3vj\Store;

if (PHP_SAPI !== "cli") {
	http_response_code(404);
	exit();
}

require __DIR__ . "/bootstrap.php";

const USAGE = <<<TXT
Usage: v-w3vj-store COMMAND [ARGS]

  set-keys                          Ask for the Razorpay key id, key secret and webhook secret
  set KEY VALUE                     Set a store setting (site_name, business_name, contact_email,
                                    contact_phone, contact_address, admin_email, policies_updated)
  add-plan PACKAGE PRICE_INR monthly|yearly "TITLE" [SORT]
                                    Create the Razorpay plan and offer it on the pricing page
  list-plans                        Show all plans
  disable-plan ID | enable-plan ID  Hide/show a plan (existing subscriptions keep running)
  refresh-plans                     Re-read package limits from the panel
  orders [STATUS]                   Show the latest orders
  maintain                          Expire unpaid orders, retry failed provisions (hourly cron)
  selftest                          Check signatures, database and panel API access
  init-db                           Create the database tables (safe to re-run)

TXT;

function out(string $line = ""): void {
	fwrite(STDOUT, $line . PHP_EOL);
}

function fail(string $message, int $code = 1): never {
	fwrite(STDERR, "ERROR: $message" . PHP_EOL);
	exit($code);
}

function ask(string $prompt, bool $secret = false): string {
	fwrite(STDOUT, $prompt);
	$tty = $secret && function_exists("posix_isatty") && posix_isatty(STDIN);
	if ($tty) {
		shell_exec("stty -echo");
	}
	$line = fgets(STDIN);
	if ($tty) {
		shell_exec("stty echo");
		fwrite(STDOUT, PHP_EOL);
	}
	return trim((string) $line);
}

function table(array $rows, array $columns): void {
	if (!$rows) {
		out("(none)");
		return;
	}
	$widths = [];
	foreach ($columns as $column) {
		$widths[$column] = max(strlen($column), ...array_map(fn($r) => mb_strlen((string) ($r[$column] ?? "")), $rows));
	}
	$line = fn(array $r) => implode("  ", array_map(fn($c) => str_pad((string) ($r[$c] ?? ""), $widths[$c]), $columns));
	out(strtoupper($line(array_combine($columns, $columns))));
	foreach ($rows as $row) {
		out($line($row));
	}
}

function refresh_limits(array $plan): void {
	$limits = hestia()->package($plan["package"]);
	if ($limits === null) {
		fail("Panel package '{$plan["package"]}' not found");
	}
	db()->prepare("UPDATE plans SET limits_json = ? WHERE id = ?")->execute([json_encode($limits), $plan["id"]]);
}

$args = array_slice($argv, 1);
$command = array_shift($args) ?? "help";

try {
	switch ($command) {
		case "init-db":
			db()->exec((string) file_get_contents(__DIR__ . "/schema.sql"));
			out("Database tables are ready.");
			break;

		case "set-keys":
			$current = config()->get("razorpay", []);
			out("Razorpay keys (Dashboard > Account & Settings > API keys; use test keys to try it out).");
			$keyId = ask("Key id [" . ($current["key_id"] ?? "") . "]: ") ?: (string) ($current["key_id"] ?? "");
			if (!preg_match('/^rzp_(test|live)_[A-Za-z0-9]{8,32}$/', $keyId)) {
				fail("Key id should look like rzp_test_XXXXXXXX or rzp_live_XXXXXXXX");
			}
			$keySecret = ask("Key secret (hidden, Enter keeps the current one): ", true) ?: (string) ($current["key_secret"] ?? "");
			$webhookSecret = ask("Webhook secret (hidden, Enter keeps the current one): ", true) ?: (string) ($current["webhook_secret"] ?? "");
			if ($keySecret === "" || $webhookSecret === "") {
				fail("Key secret and webhook secret are required");
			}
			config()->set("razorpay", ["key_id" => $keyId, "key_secret" => $keySecret, "webhook_secret" => $webhookSecret]);
			config()->save();
			out("Saved. Mode: " . (str_contains($keyId, "_live_") ? "LIVE" : "test"));
			out("Webhook URL for Razorpay: https://" . config()->get("domain") . "/api/webhook.php");
			break;

		case "set":
			$allowed = ["site_name", "business_name", "contact_email", "contact_phone", "contact_address", "admin_email", "policies_updated", "panel_url"];
			[$key, $value] = $args + [null, null];
			if (!in_array($key, $allowed, true) || $value === null) {
				fail("Usage: set KEY VALUE (KEY: " . implode(", ", $allowed) . ")");
			}
			if (in_array($key, ["contact_email", "admin_email"], true) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
				fail("$key must be an email address");
			}
			config()->set($key, str_replace("\\n", "\n", $value));
			config()->save();
			out("Saved $key.");
			break;

		case "add-plan":
			[$package, $price, $period, $title, $sort] = $args + [null, null, null, null, "0"];
			if (!$package || !preg_match('/^[A-Za-z0-9._-]{1,64}$/', $package)) {
				fail("Usage: add-plan PACKAGE PRICE_INR monthly|yearly \"TITLE\" [SORT]");
			}
			if (!is_numeric($price) || (float) $price < 1 || !in_array($period, ["monthly", "yearly"], true) || !$title) {
				fail("Usage: add-plan PACKAGE PRICE_INR monthly|yearly \"TITLE\" [SORT]");
			}
			if (hestia()->package($package) === null) {
				fail("Panel package '$package' does not exist (create it under Server > Packages first)");
			}
			$paise = (int) round((float) $price * 100);
			$site = config()->get("site_name", "W3VJHOST");
			$rzpPlan = razorpay()->createPlan($period, $paise, "$site $title");
			db()->prepare("INSERT INTO plans (package, title, price_paise, period, rzp_plan_id, sort) VALUES (?, ?, ?, ?, ?, ?)")
				->execute([$package, $title, $paise, $period, $rzpPlan["id"], (int) $sort]);
			refresh_limits(["id" => db()->lastInsertId(), "package" => $package]);
			out("Plan added: $title, " . money($paise) . " / " . Plans::periodLabel($period) . " (Razorpay {$rzpPlan["id"]})");
			break;

		case "list-plans":
			$rows = array_map(fn($p) => $p + ["price" => money((int) $p["price_paise"]), "on" => $p["active"] ? "yes" : "no"], (new Plans(db()))->all());
			table($rows, ["id", "title", "package", "price", "period", "on", "rzp_plan_id"]);
			break;

		case "disable-plan":
		case "enable-plan":
			$plan = (new Plans(db()))->find((int) ($args[0] ?? 0), false) ?? fail("Plan not found");
			db()->prepare("UPDATE plans SET active = ? WHERE id = ?")->execute([$command === "enable-plan" ? 1 : 0, $plan["id"]]);
			out(($command === "enable-plan" ? "Enabled" : "Disabled") . " plan {$plan["id"]} ({$plan["title"]}).");
			break;

		case "refresh-plans":
			foreach ((new Plans(db()))->all() as $plan) {
				refresh_limits($plan);
			}
			out("Package limits refreshed.");
			break;

		case "orders":
			$status = $args[0] ?? null;
			$stmt = db()->prepare(
				"SELECT o.id, o.created_at, o.status, o.email, o.username, o.hestia_user, p.title AS plan, o.rzp_subscription_id AS subscription, o.last_error
				 FROM orders o JOIN plans p ON p.id = o.plan_id " . ($status ? "WHERE o.status = ? " : "") . "ORDER BY o.id DESC LIMIT 50",
			);
			$stmt->execute($status ? [$status] : []);
			table($stmt->fetchAll(), ["id", "created_at", "status", "email", "username", "hestia_user", "plan", "subscription", "last_error"]);
			break;

		case "maintain":
			$quiet = in_array("--quiet", $args, true);
			// Unpaid checkouts: cancel the Razorpay subscription and release the username
			$stale = db()->query("SELECT id, rzp_subscription_id FROM orders WHERE status = 'created' AND created_at < NOW() - INTERVAL 24 HOUR")->fetchAll();
			foreach ($stale as $order) {
				if ($order["rzp_subscription_id"]) {
					try {
						$sub = razorpay()->fetchSubscription($order["rzp_subscription_id"]);
						if (in_array($sub["status"] ?? "", ["authenticated", "active"], true)) {
							// Paid after all (webhook missed): provision instead of expiring
							provisioner()->provision($order["rzp_subscription_id"]);
							continue;
						}
						if (($sub["status"] ?? "") === "created") {
							razorpay()->cancelSubscription($order["rzp_subscription_id"]);
						}
					} catch (\Throwable $e) {
						fwrite(STDERR, "order {$order["id"]}: {$e->getMessage()}" . PHP_EOL);
						continue;
					}
				}
				db()->prepare("UPDATE orders SET status = 'expired' WHERE id = ? AND status = 'created'")->execute([$order["id"]]);
			}
			$retried = provisioner()->retryFailed();
			db()->exec("DELETE FROM events WHERE received_at < NOW() - INTERVAL 90 DAY");
			if (!$quiet) {
				out("Expired/checked " . count($stale) . " unpaid order(s), provisioned $retried previously failed order(s).");
			}
			break;

		case "selftest":
			$ok = true;
			$check = function (string $name, bool $pass) use (&$ok): void {
				out(($pass ? "  ok    " : "  FAIL  ") . $name);
				$ok = $ok && $pass;
			};
			// Known vectors: HMAC-SHA256("pay_29QQoUBi66xm2f|sub_00000000000001", "test_secret")
			$sig = hash_hmac("sha256", "pay_29QQoUBi66xm2f|sub_00000000000001", "test_secret");
			$check("payment signature accepted", Razorpay::verifyPaymentSignature("pay_29QQoUBi66xm2f", "sub_00000000000001", $sig, "test_secret"));
			$check("tampered payment id rejected", !Razorpay::verifyPaymentSignature("pay_29QQoUBi66xm2X", "sub_00000000000001", $sig, "test_secret"));
			$check("wrong secret rejected", !Razorpay::verifyPaymentSignature("pay_29QQoUBi66xm2f", "sub_00000000000001", $sig, "other"));
			$check("empty secret rejected", !Razorpay::verifyPaymentSignature("pay_29QQoUBi66xm2f", "sub_00000000000001", $sig, ""));
			$body = '{"event":"subscription.charged"}';
			$check("webhook signature accepted", Razorpay::verifyWebhookSignature($body, hash_hmac("sha256", $body, "whsec"), "whsec"));
			$check("tampered webhook body rejected", !Razorpay::verifyWebhookSignature($body . " ", hash_hmac("sha256", $body, "whsec"), "whsec"));
			$check("username rules", Validate::username("good.name-1") === null && Validate::username("Bad") !== null && Validate::username("root") !== null && Validate::username("a") !== null);
			$check("generated password has upper/lower/digit", (bool) preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{20}$/', Validate::newPassword()));
			try {
				db()->query("SELECT 1 FROM orders LIMIT 1");
				$check("database reachable", true);
			} catch (\Throwable $e) {
				$check("database reachable ({$e->getMessage()})", false);
			}
			try {
				$check("panel API: user lookup works", hestia()->userExists("zz-selftest-" . random_int(1000, 9999)) === false);
			} catch (\Throwable $e) {
				$check("panel API ({$e->getMessage()})", false);
			}
			$check("Razorpay keys configured", config()->razorpayReady());
			exit($ok ? 0 : 1);

		default:
			fwrite($command === "help" ? STDOUT : STDERR, USAGE);
			exit($command === "help" ? 0 : 1);
	}
} catch (\Throwable $e) {
	fail($e->getMessage());
}
