<?php
// Plain-text mail through the local MTA (php-fpm sendmail_path in the Hestia pool template).

declare(strict_types=1);

namespace W3vj\Store;

final class Mailer {
	public function __construct(private Config $config) {}

	public function send(string $to, string $subject, string $body): bool {
		// Recipients are validated addresses; refuse anything that could inject headers
		if (!filter_var($to, FILTER_VALIDATE_EMAIL) || preg_match("/[\r\n]/", $subject)) {
			return false;
		}
		$from = (string) $this->config->get("mail_from", "");
		$headers = [
			"MIME-Version: 1.0",
			"Content-Type: text/plain; charset=UTF-8",
			"Content-Transfer-Encoding: 8bit",
		];
		if (filter_var($from, FILTER_VALIDATE_EMAIL)) {
			$headers[] = "From: " . $this->config->get("site_name", "W3VJHOST") . " <$from>";
		}
		return mail($to, mb_encode_mimeheader($subject, "UTF-8"), $body, implode("\r\n", $headers));
	}

	public function sendCredentials(string $to, string $name, string $user, string $password, string $planTitle): bool {
		$site = (string) $this->config->get("site_name", "W3VJHOST");
		$panel = (string) $this->config->get("panel_url", "");
		$body = <<<TXT
		Hello $name,

		Thank you for your order. Your $site hosting account ($planTitle) is ready.

		Control panel: $panel
		Username:      $user
		Password:      $password

		Please log in and change your password (user menu > Edit) after your first login.
		Your subscription renews automatically; you can manage it from the link in Razorpay's emails.

		The $site team
		TXT;
		return $this->send($to, "Your $site account is ready", $body);
	}

	public function notifyAdmin(string $subject, string $body): bool {
		$admin = (string) $this->config->get("admin_email", "");
		return $admin !== "" && $this->send($admin, "[Store] " . $subject, $body);
	}
}
