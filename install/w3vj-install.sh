#!/bin/bash
# ======================================================== #
#
# W3VJHOST single-command installer
#
# Builds this HestiaCP fork from the local source folder, installs it with
# the W3VJHOST defaults (all PHP versions, resource limits, quotas) and then
# installs every supported Node.js and Python runtime.
#
# Run as root on a FRESH Debian 11-13 / Ubuntu 22.04-26.04 (64-bit) server,
# from inside the repository:
#
#   bash install/w3vj-install.sh --hostname panel.example.com \
#        --email admin@example.com
#
# ======================================================== #

set -o pipefail

#----------------------------------------------------------#
#                  Variables & Functions                   #
#----------------------------------------------------------#

SRC_DIR="$(cd "$(dirname "$0")/.." && pwd)"
LOG="/root/w3vj-install-$(date +%Y%m%d-%H%M%S).log"

# Defaults favor upstream-supported PHP branches; older versions can be requested explicitly.
hostname=''
email=''
username='admin'
password=''
port='8083'
postgresql='yes'
clamav='yes'
spamassassin='yes'
webterminal='yes'
php_versions='8.3,8.4,8.5'
nodejs_versions='all'
python_versions='all'
nodejs_default='22'
python_default='3.12'
build='yes'
reboot='yes'
remove_conflicts='no'
force='no'
allow_wsl='no'
quota='yes'
resourcelimit='yes'
iptables='yes'
fail2ban='yes'

help() {
	echo "Usage: bash $0 [OPTIONS]
  --hostname NAME         Panel hostname (required, its DNS A record must point here)
  --email EMAIL           Admin email (required)
  --password PASS         Admin password (optional: leave out to get a generated one
                          and keep it out of your shell history)
  --username NAME         Admin user                     default: admin
  --port PORT             Panel port                     default: 8083
  --postgresql yes|no     Install PostgreSQL             default: yes
  --clamav yes|no         Install ClamAV (~1.5 GB RAM)   default: yes
  --spamassassin yes|no   Install SpamAssassin           default: yes
  --webterminal yes|no    Install Web Terminal           default: yes
  --php all|LIST          PHP versions (e.g. 8.3,8.4,8.5)  default: 8.3,8.4,8.5
                          all includes legacy and end-of-life PHP branches
  --nodejs all|none|LIST  Node.js versions (e.g. 22,24)  default: all
  --python all|none|LIST  Python versions (e.g. 3.12)    default: all
  --nodejs-default VER    System Node.js version         default: 22
  --python-default VER    System Python version          default: 3.12
  --build yes|no          Build packages (no = reuse /var/tmp/hestiacp-src/deb)  default: yes
  --reboot yes|no         Reboot when finished           default: yes
  --remove-conflicts yes|no  Purge packages HestiaCP refuses to install over
                          (ufw, postfix, nginx, apache2, exim4, mariadb-server)  default: no
  --force yes|no          Pass --force to the HestiaCP installer (e.g. empty netplan)  default: no
  --quota yes|no          Filesystem disk quotas         default: yes
  --resourcelimit yes|no  Per-user CPU/RAM limits (cgroups)  default: yes
  --iptables yes|no       HestiaCP firewall              default: yes
  --fail2ban yes|no       Brute-force protection         default: yes
  --allow-wsl yes|no      LAB ONLY: allow installing inside WSL  default: no
  -h, --help              Print this help"
	exit 1
}

step() { echo; echo "==> $*"; }

# hst_autocompile.sh registers NodeSource as nodesource.sources (key nodesource.gpg); the HestiaCP
# installer adds the same repository as nodejs.list (key nodejs.gpg) and apt then refuses to run
# ("Conflicting values set for option Signed-By"). Drop the build's copy, the installer adds its own.
drop_build_nodesource() {
	rm -f /etc/apt/sources.list.d/nodesource.list /etc/apt/sources.list.d/nodesource.sources \
		/usr/share/keyrings/nodesource.gpg
}
die() { echo "ERROR: $*" >&2; exit 1; }

# Map "all" / "none" / "a,b" to a version list
versions_from() {
	case "$1" in
		all) echo "$2" ;;
		none) echo "" ;;
		*) echo "${1//,/ }" ;;
	esac
}

while [ $# -gt 0 ]; do
	case "$1" in
		--hostname) hostname="$2" ;;
		--email) email="$2" ;;
		--password) password="$2" ;;
		--username) username="$2" ;;
		--port) port="$2" ;;
		--postgresql) postgresql="$2" ;;
		--clamav) clamav="$2" ;;
		--spamassassin) spamassassin="$2" ;;
		--webterminal) webterminal="$2" ;;
		--php) php_versions="$2" ;;
		--nodejs) nodejs_versions="$2" ;;
		--python) python_versions="$2" ;;
		--nodejs-default) nodejs_default="$2" ;;
		--python-default) python_default="$2" ;;
		--build) build="$2" ;;
		--reboot) reboot="$2" ;;
		--remove-conflicts) remove_conflicts="$2" ;;
		--force) force="$2" ;;
		--allow-wsl) allow_wsl="$2" ;;
		--quota) quota="$2" ;;
		--resourcelimit) resourcelimit="$2" ;;
		--iptables) iptables="$2" ;;
		--fail2ban) fail2ban="$2" ;;
		-h | --help) help ;;
		*) echo "Unknown option: $1"; help ;;
	esac
	shift 2 || help
done

#----------------------------------------------------------#
#                    Verifications                         #
#----------------------------------------------------------#

[ "$(id -u)" -eq 0 ] || die "run as root"
[ -n "$hostname" ] && [ -n "$email" ] || help
[[ "$hostname" =~ ^([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z]{2,}$ ]] || die "--hostname must be a lowercase FQDN like panel.example.com"
[[ "$email" =~ ^[^@[:space:]]+@[^@[:space:]]+\.[^@[:space:]]+$ ]] || die "--email is not a valid address"
[ -x "$SRC_DIR/src/hst_autocompile.sh" ] || die "run this script from inside the hestiacp repository"
[ -e /usr/local/hestia ] && die "HestiaCP is already installed, a fresh server is required"
[ "$(uname -m)" = "x86_64" ] || [ "$(uname -m)" = "aarch64" ] || die "64-bit (x86_64 / aarch64) required"
if grep -qi microsoft /proc/version; then
	[ "$allow_wsl" = 'yes' ] || die "WSL is not supported, use a VPS or VM (lab only: --allow-wsl yes)"
	echo "WARNING: WSL lab install - quotas, firewall, mail and SSL won't work properly. Never use for customers."
	if [ "$iptables" = 'yes' ] || [ "$fail2ban" = 'yes' ] || [ "$reboot" = 'yes' ]; then
		die "in WSL all distros share one network stack and one VM: use --iptables no --fail2ban no --reboot no"
	fi
fi
[ -d /run/systemd/system ] || die "systemd is required (WSL, OpenVZ 7 and containers without systemd are not supported)"

# shellcheck source=/dev/null
source /etc/os-release
case "$ID" in
	debian | ubuntu) os="$ID" ;;
	*) die "unsupported OS: $PRETTY_NAME" ;;
esac

mem_mb=$(awk '/MemTotal/ {print int($2/1024)}' /proc/meminfo)
disk_mb=$(df -BM --output=avail / | tail -1 | tr -dc 0-9)
[ "$mem_mb" -ge 1900 ] || die "at least 2 GB RAM is required to build packages (found ${mem_mb} MB)"
[ "$disk_mb" -ge 15000 ] || die "at least 15 GB free disk is required (found ${disk_mb} MB)"
if [ "$clamav" = 'yes' ] && [ "$mem_mb" -lt 3800 ]; then
	echo "WARNING: ClamAV with less than 4 GB RAM is slow, consider --clamav no"
fi
if ! getent hosts "$hostname" > /dev/null; then
	echo "WARNING: $hostname does not resolve yet, the panel SSL certificate will be self-signed"
fi
[[ "$port" =~ ^[0-9]{2,5}$ ]] && [ "$port" -le 65535 ] || die "--port must be a number between 10 and 65535"

# Only take the version lists, upgrade.conf also sets unrelated variables
eval "$(grep -E '^(multinode_v|multipython_v)=' "$SRC_DIR/install/upgrade/upgrade.conf")"

# Checks the HestiaCP installer does only after the long build: fail early instead.
# Same username rule and conflict list as install/hst-install-*.sh.
if ! [[ "$username" =~ ^[[:alnum:]][-|\.|_[:alnum:]]{0,28}[[:alnum:]]$ ]]; then
	die "--username '$username' is not valid (letters, digits, . _ -, 2-30 chars)"
fi
if grep -q "^$username:" /etc/passwd /etc/group; then
	die "user or group '$username' already exists on this server (Debian cloud images ship 'admin'), use --username another-name"
fi
# The installer matches these as substrings of installed package names (e.g. libnginx-mod-*),
# so collect the exact names it will find
# (removed-but-not-purged "deinstall" entries count too)
conflicts=$(dpkg --get-selections | awk '{print $1}' \
	| grep -E 'exim4|mariadb-server|apache2|nginx|hestia|postfix|ufw' | tr '\n' ' ')
if [ -n "$conflicts" ] && [ "$remove_conflicts" != 'yes' ]; then
	die "installed packages conflict with HestiaCP: $conflicts
       Rerun with --remove-conflicts yes to purge them, or use a clean server.
       ufw is safe to remove: HestiaCP manages its own firewall."
fi
if [ -d /etc/netplan ] && [ -z "$(ls -A /etc/netplan)" ] && [ "$force" != 'yes' ]; then
	die "/etc/netplan is empty, HestiaCP would stop to ask about it. Extra IPs won't work without netplan; rerun with --force yes to continue anyway"
fi
legacy_php_selected='no'
if [ "$php_versions" != 'all' ]; then
	multiphp_list=$(grep -E '^multiphp_v=' "$SRC_DIR/install/hst-install-$os.sh" | head -1)
	for v in ${php_versions//,/ }; do
		[[ "$multiphp_list" == *"\"$v\""* ]] || die "PHP $v is not supported by HestiaCP on $PRETTY_NAME"
		if [[ "$v" =~ ^([0-9]+)\.([0-9]+)$ ]]; then
			php_major=${BASH_REMATCH[1]}
			php_minor=${BASH_REMATCH[2]}
			if (( php_major < 8 || (php_major == 8 && php_minor < 3) )); then
				legacy_php_selected='yes'
			fi
		fi
	done
fi
for v in $(versions_from "$nodejs_versions" ""); do
	[[ " ${multinode_v[*]} " == *" $v "* ]] || die "Node.js $v is not supported (supported: ${multinode_v[*]})"
done
for v in $(versions_from "$python_versions" ""); do
	[[ " ${multipython_v[*]} " == *" $v "* ]] || die "Python $v is not supported (supported: ${multipython_v[*]})"
done

# Debian 13 mounts /tmp as a small tmpfs, so build on disk instead
export BUILD_DIR="/var/tmp/hestiacp-src"
deb_dir="$BUILD_DIR/deb"

nodejs_list=$(versions_from "$nodejs_versions" "${multinode_v[*]}")
python_list=$(versions_from "$python_versions" "${multipython_v[*]}")

echo "W3VJHOST installer"
echo "  OS:        $PRETTY_NAME ($(uname -m)), ${mem_mb} MB RAM, ${disk_mb} MB free"
echo "  Panel:     https://$hostname:$port  (user: $username)"
if [ "$php_versions" = 'all' ]; then
	echo "  PHP:       all versions HestiaCP supports"
	echo "             WARNING: includes legacy/EOL branches; prefer --php 8.3,8.4,8.5"
else
	echo "  PHP:       $php_versions"
fi
if [ "$legacy_php_selected" = 'yes' ]; then
	echo "             WARNING: PHP 8.2 receives upstream security fixes only until 2026-12-31; older branches are EOL."
	echo "                      Verify vendor backports and avoid installing versions you do not need."
fi
echo "  Node.js:   ${nodejs_list:-none} (default $nodejs_default)"
echo "  Python:    ${python_list:-none} (default $python_default)"
echo "  Log:       $LOG"
[ -z "$password" ] && echo "  Password:  generated, shown at the end and in the root-only log"
[ -n "$conflicts" ] && echo "  Removing:  $conflicts"
echo "Starting in 10 seconds, press Ctrl+C to cancel..."
sleep 10

# The log can contain the admin password, keep it root-only.
# Only the log file: a global umask would break the files the installer creates.
install -m 600 /dev/null "$LOG"
exec > >(tee -a "$LOG") 2>&1

#----------------------------------------------------------#
#                       Action                             #
#----------------------------------------------------------#

step "1/4 Installing build tools"
# hst_autocompile.sh installs the compilers and Node.js (NodeSource, distro fallback) itself
if [ -n "$conflicts" ]; then
	# shellcheck disable=SC2086 # one argument per package name
	apt-get -qq purge -y $conflicts > /dev/null || die "removing conflicting packages failed: $conflicts"
fi
# A previous failed attempt can leave both NodeSource entries behind, which breaks apt-get update
[ -f /etc/apt/sources.list.d/nodejs.list ] && drop_build_nodesource
apt-get update -qq || die "apt-get update failed"
apt-get install -y -qq ca-certificates curl wget git xz-utils > /dev/null || die "installing build tools failed"

if [ "$build" = 'yes' ]; then
	step "2/4 Building HestiaCP packages from $SRC_DIR (takes 10-30 minutes)"
	cd "$SRC_DIR/src" || die "missing src folder"
	./hst_autocompile.sh --all --noinstall --keepbuild '~localsrc' || die "package build failed, see $LOG"
else
	step "2/4 Skipping build, reusing $deb_dir"
fi
ls "$deb_dir"/*.deb > /dev/null 2>&1 || die "no packages found in $deb_dir"

drop_build_nodesource

step "3/4 Installing HestiaCP"
cd "$SRC_DIR/install" || die "missing install folder"
# HestiaCP never generates a password itself: without -p it loops on `read` forever when
# stdin isn't a terminal. Generate one here and hand it over on stdin, so it never appears
# in the process list (argv) either.
generated_password='no'
if [ -z "$password" ]; then
	password=$(tr -dc 'A-Za-z0-9' < /dev/urandom | head -c 20)
	generated_password='yes'
fi
extra_args=()
[ "$force" = 'yes' ] && extra_args+=(--force)
php_arg="yes"
[ "$php_versions" != 'all' ] && php_arg="$php_versions"
printf '%s\n' "$password" | bash "hst-install-$os.sh" --with-debs "$deb_dir/" --interactive no \
	--hostname "$hostname" --email "$email" --username "$username" "${extra_args[@]}" \
	--port "$port" --multiphp "$php_arg" --resourcelimit "$resourcelimit" --quota "$quota" --api yes \
	--postgresql "$postgresql" --clamav "$clamav" --spamassassin "$spamassassin" \
	--webterminal "$webterminal" --iptables "$iptables" --fail2ban "$fail2ban" \
	|| die "HestiaCP installation failed, see $LOG
       A half-finished install can't be repaired by rerunning: reinstall the OS, then run this again
       with --build no to reuse the packages already built in $deb_dir."

step "4/4 Branding, update protection and application runtimes"
BIN=/usr/local/hestia/bin
failed=''

# The installer added apt.hestiacp.com and daily auto-updates. Upstream's next "hestia"
# release would replace this fork and silently remove the W3VJHOST changes, so never
# take the core package from there. hestia-nginx/-php/-web-terminal keep upstream security
# updates. Update W3VJHOST with: cd src && ./hst_autocompile.sh --hestia --install '~localsrc'
cat > /etc/apt/preferences.d/w3vjhost-hestia << 'EOF'
# W3VJHOST: the hestia core package is built from the W3VJHOST fork, never from upstream
Package: hestia
Pin: origin apt.hestiacp.com
Pin-Priority: -1
EOF
apt-get update -qq > /dev/null 2>&1
if apt-cache policy hestia | grep -q 'apt.hestiacp.com' && apt-get -s upgrade 2> /dev/null | grep -q '^Inst hestia '; then
	failed="$failed update-pin"
fi

$BIN/v-change-sys-config-value 'APP_NAME' 'W3VJHOST' || failed="$failed app-name"
$BIN/v-update-white-label-logo yes || failed="$failed branding"
for v in $nodejs_list; do
	$BIN/v-add-web-nodejs "$v" || failed="$failed node-$v"
done
for v in $python_list; do
	$BIN/v-add-web-python "$v" || failed="$failed python-$v"
done
if [[ " $nodejs_list " == *" $nodejs_default "* ]]; then
	$BIN/v-change-sys-nodejs "$nodejs_default" || failed="$failed node-default"
fi
if [[ " $python_list " == *" $python_default "* ]]; then
	$BIN/v-change-sys-python "$python_default" || failed="$failed python-default"
fi

#----------------------------------------------------------#
#                       Summary                            #
#----------------------------------------------------------#

echo
echo "=================================================================="
echo " W3VJHOST installed"
echo "   Panel:    https://$hostname:$port"
echo "   User:     $username"
if [ "$generated_password" = 'yes' ]; then
	echo "   Password: $password   (generated - change it after the first login)"
fi
echo "   PHP:      $($BIN/v-list-sys-php plain | tr '\n' ' ')"
echo "   Node.js:  $($BIN/v-list-sys-nodejs plain | tr '\n' ' ')"
echo "   Python:   $($BIN/v-list-sys-python plain | tr '\n' ' ')"
echo "   Updates:  hestia core pinned to this fork (/etc/apt/preferences.d/w3vjhost-hestia)"
[ -n "$failed" ] && echo "   FAILED:  $failed (see the messages above; update-pin = check apt-cache policy hestia)"
echo "   Log:      $LOG"
echo "=================================================================="

if [ "$reboot" = 'yes' ]; then
	echo "Rebooting in 15 seconds to finish the installation (Ctrl+C to cancel)..."
	sleep 15
	reboot
else
	echo "IMPORTANT: reboot the server before using it."
fi
