# W3VJHOST Fresh VPS Installation

This guide installs W3VJHOST on a **fresh, 64-bit Debian or Ubuntu VPS**. It installs the panel and the installer's default services, including Nginx, Apache, MariaDB, DNS, mail, firewall, Fail2ban, ClamAV, SpamAssassin, PostgreSQL, Web Terminal, all supported Node.js runtimes, and all supported Python runtimes.

PHP defaults to **8.3, 8.4, and 8.5**. It intentionally does not install every legacy PHP branch.

## Before you start

- Use a fresh Debian 11-13 or Ubuntu 22.04-26.04 installation with systemd.
- Use a 64-bit KVM/LXC VPS. The installer requires at least 2 GB RAM and 15 GB free disk space to build packages. ClamAV is resource-intensive; 4 GB RAM or more is recommended.
- Point the panel hostname's DNS A record to the VPS public IP before installation. For example, `panel.example.com`.
- Have an email address for the panel administrator.
- Run as `root`, either directly in the VPS console or over SSH. This installation modifies the operating system, installs server services, and reboots by default.
- Use the HTTPS Git URL for the W3VJHOST source repository. **Do not substitute the upstream HestiaCP repository**: it does not contain the W3VJHOST installer or changes.

## One-command install

Replace the example hostname and email with your own values. Run the resulting single line as root:

```bash
git clone https://github.com/w3vjtech/w3vjhost.git /root/w3vjhost && cd /root/w3vjhost && bash install/w3vj-install.sh --hostname panel.example.com --email admin@example.com --username admin --port 8083 --php 8.3,8.4,8.5 --nodejs 22,24 --python 3.11,3.12,3.13 --nodejs-default 22 --python-default 3.12 --postgresql yes --clamav yes --spamassassin yes --webterminal yes --quota yes --resourcelimit yes --iptables yes --fail2ban yes --build yes --reboot yes
```

This command selects Node.js 22 and 24 and Python 3.11, 3.12, and 3.13 rather than `all`, which also includes end-of-life branches in the current installer. Install older runtimes only when required by an application, and ensure they receive security fixes from their package vendor. Selecting multiple runtimes takes additional time and disk space. The installer builds packages from the cloned source, installs the panel and default service set, sets the customer-facing panel name to W3VJHOST, and reboots when finished. It generates an administrator password rather than putting a password in shell history or the command line. Record the password shown at completion; the installer also writes a root-only log under `/root/`.

Log in at `https://panel.example.com:8083` after the server reboots. The browser may warn about a self-signed certificate if the hostname does not resolve correctly or certificate issuance failed. Do not ignore certificate errors on a public production server; resolve DNS and install a trusted certificate.

## Installer options and safety

- To prevent automatic reboot, add `--reboot no`. Reboot manually after installation.
- To install a smaller set of PHP, Node.js, or Python branches, pass comma-separated lists supported by this source, such as `--php 8.4,8.5 --nodejs 24 --python 3.12,3.13`.
- Avoid `--php all` on production: it includes legacy and end-of-life PHP branches. Install only versions customers need and keep every web-serving runtime patched through its OS/vendor package source.
- Optional services can be disabled with flags such as `--clamav no`, `--spamassassin no`, `--postgresql no`, or `--webterminal no`. Review the installer's help before changing defaults:

  ```bash
  bash install/w3vj-install.sh --help
  ```

- Do not run this installer on a VPS containing websites, mail, databases, or other production data. It is designed for a fresh server and may remove conflicting packages when explicitly requested.
- Keep SSH access available during setup and ensure the VPS provider's firewall permits the services and ports you intend to use.
- After installation, verify updates, backups, DNS, firewall rules, mail delivery, and all installed PHP-FPM runtimes before moving production workloads.

## Repository URL note

The one-command example uses `https://github.com/w3vjtech/w3vjhost.git`. Ensure this repository contains the W3VJHOST source, including `install/w3vj-install.sh`, before running the installer. The current local checkout still points to the upstream HestiaCP repository; this documentation change does not push or publish source code.
