<?php

declare(strict_types=1);

namespace W3vj\Store;

final class Db {
	public static function connect(Config $config): \PDO {
		$db = $config->get("db", []);
		return new \PDO(
			sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", $db["host"] ?? "localhost", $db["name"] ?? ""),
			(string) ($db["user"] ?? ""),
			(string) ($db["pass"] ?? ""),
			[
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES => false,
			],
		);
	}
}
