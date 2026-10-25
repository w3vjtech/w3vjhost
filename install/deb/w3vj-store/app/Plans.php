<?php

declare(strict_types=1);

namespace W3vj\Store;

final class Plans {
	public function __construct(private \PDO $db) {}

	public function active(): array {
		return $this->db->query("SELECT * FROM plans WHERE active = 1 ORDER BY sort, price_paise")->fetchAll();
	}

	public function all(): array {
		return $this->db->query("SELECT * FROM plans ORDER BY active DESC, sort, price_paise")->fetchAll();
	}

	public function find(int $id, bool $activeOnly = true): ?array {
		$stmt = $this->db->prepare("SELECT * FROM plans WHERE id = ?" . ($activeOnly ? " AND active = 1" : ""));
		$stmt->execute([$id]);
		return $stmt->fetch() ?: null;
	}

	// Human-readable limits from the cached Hestia package (shown on the pricing cards)
	public static function features(array $plan): array {
		$limits = json_decode((string) ($plan["limits_json"] ?? ""), true) ?: [];
		$fmt = fn($v) => $v === "unlimited" ? "Unlimited" : (string) $v;
		$features = [];
		$map = [
			"WEB_DOMAINS" => "website(s)",
			"DATABASES" => "database(s)",
			"MAIL_ACCOUNTS" => "email account(s)",
			"CRON_JOBS" => "cron job(s)",
			"BACKUPS" => "backup(s)",
		];
		if (isset($limits["DISK_QUOTA"])) {
			$features[] = $limits["DISK_QUOTA"] === "unlimited" ? "Unlimited disk" : $limits["DISK_QUOTA"] . " MB disk";
		}
		if (isset($limits["BANDWIDTH"])) {
			$features[] = $limits["BANDWIDTH"] === "unlimited" ? "Unlimited bandwidth" : $limits["BANDWIDTH"] . " MB bandwidth";
		}
		foreach ($map as $key => $label) {
			if (isset($limits[$key]) && $limits[$key] !== "0") {
				$features[] = $fmt($limits[$key]) . " " . $label;
			}
		}
		$features[] = "Free SSL certificates";
		return $features;
	}

	public static function periodLabel(string $period): string {
		return $period === "yearly" ? "year" : "month";
	}
}
