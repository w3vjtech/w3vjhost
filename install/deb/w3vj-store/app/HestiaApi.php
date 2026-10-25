<?php
// Client for the panel's REST API (web/api/index.php) using an access key limited to the
// "w3vj-store" permission set (install/common/api/w3vj-store). The store never runs as root.

declare(strict_types=1);

namespace W3vj\Store;

final class HestiaApi {
	// Exit codes from func/main.sh
	public const OK = 0;
	public const E_NOTEXIST = 3;
	public const E_EXISTS = 4;

	public function __construct(
		private string $url,
		private string $accessKey,
		private string $secretKey,
		private ?string $caFile = null,
		private ?string $resolve = null,
	) {}

	public static function fromConfig(Config $config): self {
		$api = $config->get("hestia", []);
		return new self(
			(string) ($api["url"] ?? ""),
			(string) ($api["access_key"] ?? ""),
			(string) ($api["secret_key"] ?? ""),
			$api["cafile"] ?? null,
			$api["resolve"] ?? null,
		);
	}

	/** @return array{code: int, output: string} */
	public function call(string $command, array $args = []): array {
		$fields = ["access_key" => $this->accessKey, "secret_key" => $this->secretKey, "cmd" => $command];
		foreach (array_values($args) as $i => $arg) {
			$fields["arg" . ($i + 1)] = (string) $arg;
		}

		$exitCode = null;
		$ch = curl_init($this->url);
		$options = [
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($fields),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT => 120,
			// Commands report their exit code in this header (web/api/index.php)
			CURLOPT_HEADERFUNCTION => function ($ch, string $header) use (&$exitCode): int {
				if (preg_match('/^Hestia-Exit-Code:\s*(\d+)/i', $header, $m)) {
					$exitCode = (int) $m[1];
				}
				return strlen($header);
			},
		];
		// The panel certificate may be self-signed: trust exactly that certificate, never disable checks
		if (!empty($this->caFile)) {
			$options[CURLOPT_CAINFO] = $this->caFile;
		}
		// Connect to 127.0.0.1 while verifying the certificate for the panel hostname
		if (!empty($this->resolve)) {
			$options[CURLOPT_RESOLVE] = [$this->resolve];
		}
		curl_setopt_array($ch, $options);
		$body = curl_exec($ch);
		$status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		$error = curl_error($ch);
		curl_close($ch);

		if ($body === false) {
			throw new HestiaApiException("Panel API connection failed: $error");
		}
		if ($exitCode === null) {
			// Authentication or permission errors are answered before a command runs
			throw new HestiaApiException("Panel API refused the request (HTTP $status): " . substr(trim((string) $body), 0, 200));
		}
		return ["code" => $exitCode, "output" => trim((string) $body)];
	}

	public function userExists(string $user): bool {
		$result = $this->call("v-list-user", [$user, "json"]);
		return match ($result["code"]) {
			self::OK => true,
			self::E_NOTEXIST => false,
			default => throw new HestiaApiException("v-list-user failed: " . $result["output"]),
		};
	}

	public function package(string $name): ?array {
		$result = $this->call("v-list-user-package", [$name, "json"]);
		if ($result["code"] !== self::OK) {
			return null;
		}
		$data = json_decode($result["output"], true);
		return is_array($data[$name] ?? null) ? $data[$name] : null;
	}

	public function addUser(string $user, string $password, string $email, string $package, string $name): void {
		$this->expectOk("v-add-user", [$user, $password, $email, $package, $name], "create account $user");
	}

	public function suspendUser(string $user): void {
		$this->expectOk("v-suspend-user", [$user], "suspend $user");
	}

	public function unsuspendUser(string $user): void {
		$this->expectOk("v-unsuspend-user", [$user], "unsuspend $user");
	}

	private function expectOk(string $command, array $args, string $what): void {
		$result = $this->call($command, $args);
		if ($result["code"] !== self::OK) {
			throw new HestiaApiException("Could not $what: " . substr($result["output"], 0, 200), $result["code"]);
		}
	}
}
