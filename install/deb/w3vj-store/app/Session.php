<?php
// Session cookie + CSRF token for the checkout pages.

declare(strict_types=1);

namespace W3vj\Store;

final class Session {
	public static function start(): void {
		if (session_status() === PHP_SESSION_ACTIVE) {
			return;
		}
		session_name("w3vjstore");
		session_set_cookie_params([
			"lifetime" => 0,
			"path" => "/",
			"secure" => true,
			"httponly" => true,
			// Lax: the Razorpay modal posts to us from our own page, not cross-site
			"samesite" => "Lax",
		]);
		session_start();
	}

	public static function csrfToken(): string {
		self::start();
		return $_SESSION["csrf"] ??= bin2hex(random_bytes(32));
	}

	public static function checkCsrf(?string $token): bool {
		self::start();
		return is_string($token) && isset($_SESSION["csrf"]) && hash_equals($_SESSION["csrf"], $token);
	}
}
