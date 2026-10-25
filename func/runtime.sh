#!/bin/bash

#===========================================================================#
#                                                                           #
# Hestia Control Panel - W3VJ Application Runtime Function Library          #
#                                                                           #
#===========================================================================#

# Node.js and Python runtimes are managed like multi-PHP:
#   versions live in /opt/w3vj/<runtime>/<version>
#   the system default is the symlink /opt/w3vj/<runtime>/default
#   each installed version has an app template in $WEBTPL/<runtime>/

W3VJ_RUNTIME_DIR="/opt/w3vj"
W3VJ_NODEJS_DIR="$W3VJ_RUNTIME_DIR/nodejs"
W3VJ_PYTHON_DIR="$W3VJ_RUNTIME_DIR/python"
W3VJ_UV="$W3VJ_RUNTIME_DIR/bin/uv"
W3VJ_SOCKET_DIR="/run/w3vj"
W3VJ_LOG_DIR="/var/log/w3vj/apps"

# Supported versions from install/upgrade/upgrade.conf, one per line.
# upgrade.conf writes them as bash arrays, but source_conf() loads each line as plain text
# (multinode_v becomes the single string '("20" "22" "24")'), so read the file directly.
# Usage: runtime_supported_versions multinode_v|multipython_v
runtime_supported_versions() {
	grep -E "^$1=" "$HESTIA/install/upgrade/upgrade.conf" | grep -oE '"[^"]+"' | tr -d '"'
}

# Check that a version is in a supported version list (exact match)
# Usage: is_runtime_version_supported VERSION $(runtime_supported_versions multinode_v)
is_runtime_version_supported() {
	local version="$1"
	shift
	local v
	for v in "$@"; do
		if [ "$v" = "$version" ]; then
			return 0
		fi
	done
	return 1
}

# List installed versions of a runtime directory, sorted
# Usage: runtime_versions DIR
runtime_versions() {
	local dir="$1"
	local path
	[ -d "$dir" ] || return 0
	for path in "$dir"/*; do
		[ -d "$path" ] && echo "${path##*/}"
	done | grep -E '^[0-9]+(\.[0-9]+)?$' | sort -V
}

# Print the system default version of a runtime directory
# Usage: runtime_default_version DIR
runtime_default_version() {
	local dir="$1"
	if [ -L "$dir/default" ]; then
		basename "$(readlink "$dir/default")"
	fi
}

# Check if an app template is used by any web domain
# Usage: is_app_template_in_use TEMPLATE
is_app_template_in_use() {
	grep -qs "APP_TEMPLATE='$1'" "$HESTIA"/data/users/*/web.conf
}

# Read an app key straight from the domain line. get_domain_values leaves values
# from the previous domain behind when a line lacks the key, so never trust those.
# Usage: get_web_app_value KEY (uses $user, $domain)
get_web_app_value() {
	grep -F "DOMAIN='$domain' " "$USER_DATA/web.conf" | grep -o " $1='[^']*'" | cut -f 2 -d \'
}

# Resolve an app template (NODE-22, PY-3_12) to its runtime, version and files
# Sets: app_runtime app_version app_runtime_dir app_tpl
prepare_app_template() {
	case "$1" in
		NODE-*)
			app_runtime="nodejs"
			app_version="${1#NODE-}"
			app_runtime_dir="$W3VJ_NODEJS_DIR/$app_version"
			;;
		PY-*)
			app_runtime="python"
			app_version="${1#PY-}"
			app_version="${app_version/_/.}"
			app_runtime_dir="$W3VJ_PYTHON_DIR/$app_version"
			;;
	esac
	app_tpl="$WEBTPL/$app_runtime/$1.tpl"
}

# Check that an app template and its runtime are installed
is_app_template_valid() {
	prepare_app_template "$1"
	if [ ! -f "$app_tpl" ] || [ ! -d "$app_runtime_dir" ]; then
		check_result "$E_NOTEXIST" "$1 app template doesn't exist"
	fi
}

# Check the entry matches the runtime: a file for Node.js, module:callable for Python
is_app_entry_valid() {
	if [ "$app_runtime" = "python" ]; then
		if ! [[ "$1" =~ ^[A-Za-z_][A-Za-z0-9_.]*:[A-Za-z_][A-Za-z0-9_]*(\(\))?$ ]]; then
			check_result "$E_INVALID" "Python entry must look like module:app (example wsgi:app)"
		fi
	elif [[ "$1" == /* ]] || [[ "$1" == *:* ]] || [[ "$1" == *[\(\)]* ]]; then
		check_result "$E_INVALID" "Node.js entry must be a file inside the app directory (example server.js)"
	fi
}

# Paths of a domain application (uses $user, $domain)
# Domains are stored in Unicode, but systemd unit names must be ASCII and a Unix
# socket path must fit in 108 bytes, so long names are shortened with a hash.
prepare_web_app_paths() {
	app_name="$domain"
	if [[ "$app_name" = *[![:ascii:]]* ]]; then
		app_name=$(idn2 --quiet "$app_name")
	fi
	if [ "${#app_name}" -gt 53 ]; then
		app_name="${app_name:0:40}-$(printf '%s' "$app_name" | sha256sum | cut -c 1-12)"
	fi
	app_dir="$HOMEDIR/$user/web/$domain/app"
	app_socket_dir="$W3VJ_SOCKET_DIR/$user"
	app_socket="$app_socket_dir/$app_name.sock"
	app_unit="w3vj-app-$app_name.service"
	app_log="$W3VJ_LOG_DIR/$app_name.log"
}

# Root-owned log file readable by the user, linked into the domain logs folder
# like the nginx logs. systemd opens it as root, so it must never be user-owned.
prepare_web_app_log() {
	mkdir -p "$W3VJ_LOG_DIR"
	chmod 751 "$W3VJ_LOG_DIR"
	if [ -L "$app_log" ] || [ ! -f "$app_log" ]; then
		rm -f "$app_log"
		touch "$app_log"
	fi
	chown root:"$user" "$app_log"
	chmod 640 "$app_log"
	if [ -d "$HOMEDIR/$user/web/$domain/logs" ]; then
		user_exec ln -sfn "$app_log" "$HOMEDIR/$user/web/$domain/logs/app.log"
	fi
	if [ ! -f /etc/logrotate.d/w3vj-apps ] && [ -f "$HESTIA_INSTALL_DIR/logrotate/w3vj-apps" ]; then
		cp -f "$HESTIA_INSTALL_DIR/logrotate/w3vj-apps" /etc/logrotate.d/w3vj-apps
	fi
}

# Write the systemd unit of a domain application from its template
# Usage: add_web_app_unit TEMPLATE ENTRY (uses $user, $domain)
add_web_app_unit() {
	prepare_app_template "$1"
	prepare_web_app_paths
	prepare_web_app_log
	sed -e "s|%user%|$user|g" \
		-e "s|%app_log%|$app_log|g" \
		-e "s|%uid%|$(id -u "$user")|g" \
		-e "s|%domain%|$domain|g" \
		-e "s|%backend_version%|$app_version|g" \
		-e "s|%app_dir%|$app_dir|g" \
		-e "s|%app_entry%|$2|g" \
		-e "s|%app_socket%|$app_socket|g" \
		-e "s|%socket_dir%|$app_socket_dir|g" \
		"$app_tpl" > "/etc/systemd/system/$app_unit"
	chmod 644 "/etc/systemd/system/$app_unit"
	systemctl daemon-reload
}

# Remove the systemd unit and socket of a domain application (uses $user, $domain)
delete_web_app_unit() {
	prepare_web_app_paths
	systemctl disable --now "$app_unit" > /dev/null 2>&1
	rm -f "/etc/systemd/system/$app_unit" "$app_socket" "$app_log"*
	systemctl daemon-reload
	systemctl reset-failed "$app_unit" > /dev/null 2>&1
}

# Start a domain application and wait for its socket
# Returns 0 when the socket is up, 1 otherwise (uses $user, $domain)
start_web_app() {
	prepare_web_app_paths
	systemctl enable "$app_unit" > /dev/null 2>&1
	systemctl restart "$app_unit" > /dev/null 2>&1
	local i
	for i in $(seq 1 20); do
		[ -S "$app_socket" ] && return 0
		systemctl is-failed --quiet "$app_unit" && return 1
		sleep 0.5
	done
	return 1
}

# Live status of a domain application: running, stopped or failed
web_app_status() {
	prepare_web_app_paths
	if systemctl is-active --quiet "$app_unit"; then
		echo "running"
	elif systemctl is-failed --quiet "$app_unit"; then
		echo "failed"
	else
		echo "stopped"
	fi
}

# Map machine architecture to Node.js release naming
nodejs_arch() {
	case "$(uname -m)" in
		x86_64) echo "x64" ;;
		aarch64) echo "arm64" ;;
		*) return 1 ;;
	esac
}

# Map machine architecture to uv release naming
uv_arch() {
	case "$(uname -m)" in
		x86_64) echo "x86_64" ;;
		aarch64) echo "aarch64" ;;
		*) return 1 ;;
	esac
}

# Install the uv Python manager if it is missing
install_uv() {
	if [ -x "$W3VJ_UV" ]; then
		return 0
	fi

	local arch file url tmp
	arch=$(uv_arch) || check_result "$E_INVALID" "Unsupported architecture $(uname -m)"
	file="uv-${arch}-unknown-linux-gnu.tar.gz"
	url="https://github.com/astral-sh/uv/releases/latest/download"
	tmp=$(mktemp -d)

	if ! wget --quiet --retry-connrefused "$url/$file" -O "$tmp/$file" \
		|| ! wget --quiet --retry-connrefused "$url/$file.sha256" -O "$tmp/$file.sha256"; then
		rm -rf "$tmp"
		check_result "$E_CONNECT" "Unable to download uv"
	fi
	if ! (cd "$tmp" && sha256sum --check --status "$file.sha256"); then
		rm -rf "$tmp"
		check_result "$E_INVALID" "uv checksum verification failed"
	fi

	mkdir -p "$W3VJ_RUNTIME_DIR/bin"
	tar -xzf "$tmp/$file" -C "$tmp"
	install -m 755 -o root -g root "$tmp/uv-${arch}-unknown-linux-gnu/uv" "$W3VJ_UV"
	rm -rf "$tmp"
}
