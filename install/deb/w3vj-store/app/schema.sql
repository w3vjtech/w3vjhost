-- W3VJHOST Store schema (MariaDB). Applied by `cli.php init-db`; safe to re-run.

CREATE TABLE IF NOT EXISTS plans (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	package VARCHAR(64) NOT NULL,
	title VARCHAR(100) NOT NULL,
	price_paise INT UNSIGNED NOT NULL,
	period ENUM('monthly', 'yearly') NOT NULL,
	rzp_plan_id VARCHAR(40) NOT NULL,
	-- Hestia package limits, cached so the public pricing page makes no panel API calls
	limits_json TEXT NULL,
	active TINYINT(1) NOT NULL DEFAULT 1,
	sort INT NOT NULL DEFAULT 0,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	UNIQUE KEY uq_rzp_plan (rzp_plan_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS orders (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	token CHAR(32) NOT NULL,
	plan_id INT UNSIGNED NOT NULL,
	email VARCHAR(190) NOT NULL,
	name VARCHAR(100) NOT NULL,
	username VARCHAR(30) NOT NULL,
	hestia_user VARCHAR(30) NULL,
	rzp_subscription_id VARCHAR(40) NULL,
	rzp_payment_id VARCHAR(40) NULL,
	status ENUM('created', 'provisioned', 'failed', 'suspended', 'cancelled', 'expired') NOT NULL DEFAULT 'created',
	attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
	last_error VARCHAR(255) NULL,
	ip VARCHAR(45) NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UNIQUE KEY uq_token (token),
	UNIQUE KEY uq_subscription (rzp_subscription_id),
	KEY ix_status (status, created_at),
	KEY ix_ip (ip, created_at),
	KEY ix_username (username, status),
	CONSTRAINT fk_orders_plan FOREIGN KEY (plan_id) REFERENCES plans (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Razorpay webhook event ids already handled (Razorpay may deliver an event more than once)
CREATE TABLE IF NOT EXISTS events (
	event_id VARCHAR(64) PRIMARY KEY,
	type VARCHAR(64) NOT NULL,
	received_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
