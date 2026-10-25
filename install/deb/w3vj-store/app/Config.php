<?php
// Store settings, kept in private/store/config.json (mode 0600, owner only).
// Written by v-add-sys-w3vj-store; Razorpay keys are added with `v-w3vj-store set-keys`.

declare(strict_types=1);

namespace W3vj\Store;

final class Config {
	private function __construct(private string $path, private array $data) {}

	public static function load(string $path): self {
		$json = @file_get_contents($path);
		if ($json === false) {
			throw new \RuntimeException("Store config not readable: $path");
		}
		$data = json_decode($json, true);
		if (!is_array($data)) {
			throw new \RuntimeException("Store config is not valid JSON: $path");
		}
		return new self($path, $data);
	}

	public function get(string $key, mixed $default = null): mixed {
		return $this->data[$key] ?? $default;
	}

	public function set(string $key, mixed $value): void {
		$this->data[$key] = $value;
	}

	// Atomic write that keeps the file private
	public function save(): void {
		$tmp = $this->path . ".tmp";
		$json = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
		$old = umask(0077);
		try {
			if (file_put_contents($tmp, $json, LOCK_EX) === false || !rename($tmp, $this->path)) {
				throw new \RuntimeException("Could not write store config");
			}
		} finally {
			umask($old);
		}
		chmod($this->path, 0600);
	}

	public function razorpayReady(): bool {
		$rzp = $this->get("razorpay", []);
		return !empty($rzp["key_id"]) && !empty($rzp["key_secret"]) && !empty($rzp["webhook_secret"]);
	}
}
