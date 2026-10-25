<?php
// Input rules shared by the checkout form and provisioning.

declare(strict_types=1);

namespace W3vj\Store;

final class Validate {
	// Names bin/v-add-user refuses (is_user_free), plus system and panel accounts
	private const RESERVED = [
		"aria", "aria_log", "mysql", "mysql_upgrade", "ib", "ib_buffer", "ddl", "ddl_recovery",
		"performance", "sudo", "root", "admin", "administrator", "hestia", "hestiaweb", "hestiamail",
		"www-data", "nobody", "daemon", "bin", "sys", "mail", "postmaster", "webmaster", "support",
		"w3vjhost", "w3vj", "test",
	];

	// Same shape as is_user_format_valid in func/main.sh, lowercase only
	public static function username(string $value): ?string {
		if (!preg_match('/^[a-z0-9][a-z0-9._-]{0,28}[a-z0-9]$/', $value)) {
			return "Use 2-30 lowercase letters, digits, dots, dashes or underscores; start and end with a letter or digit.";
		}
		if (in_array($value, self::RESERVED, true)) {
			return "This username is reserved, please choose another one.";
		}
		return null;
	}

	public static function email(string $value): ?string {
		return strlen($value) <= 190 && filter_var($value, FILTER_VALIDATE_EMAIL) ? null : "Please enter a valid email address.";
	}

	public static function name(string $value): ?string {
		if ($value === "" || mb_strlen($value) > 100) {
			return "Please enter your name (up to 100 characters).";
		}
		// Letters, marks, spaces and common punctuation only: the name goes into the panel and emails
		return preg_match("/^[\p{L}\p{M}][\p{L}\p{M} .'-]*$/u", $value) ? null : "Please use letters, spaces, dots, apostrophes or dashes.";
	}

	// 20 characters with upper, lower and digit (the panel's password rules)
	public static function newPassword(int $length = 20): string {
		$alphabet = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789";
		do {
			$password = "";
			for ($i = 0; $i < $length; $i++) {
				$password .= $alphabet[random_int(0, strlen($alphabet) - 1)];
			}
		} while (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/\d/", $password));
		return $password;
	}
}
