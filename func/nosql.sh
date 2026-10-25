#!/bin/bash

nosql_validate_name() {
	if [[ ! "$1" =~ ^[a-z][a-z0-9_]{0,31}$ ]]; then
		check_result "$E_INVALID" "invalid NoSQL database name :: $1"
	fi
}

# Prefix for server-side names (databases, users, key namespaces). HestiaCP usernames may contain
# "." and "-", which MongoDB database names can't, so they become "_".
nosql_object_name() {
	printf 'w3vj_%s_%s\n' "${1//[^a-z0-9_]/_}" "$2"
}

nosql_record_file() {
	case "$1" in
		mongodb) printf '%s\n' "$USER_DATA/nosql-mongodb.conf" ;;
		redis) printf '%s\n' "$USER_DATA/nosql-redis.conf" ;;
		*) check_result "$E_INVALID" "invalid NoSQL database type :: $1" ;;
	esac
}

nosql_load_service_config() {
	local service=$1
	local conf="$HESTIA/conf/$service.conf"

	if [ ! -f "$conf" ]; then
		check_result "$E_DISABLED" "$service is not installed"
	fi

	parse_object_kv_list "$(cat "$conf")"
	NOSQL_SERVICE_USER=${USER-}
	NOSQL_SERVICE_PASSWORD=$PASSWORD
	NOSQL_SERVICE_PORT=$PORT
	NOSQL_SERVICE_STATUS=${SUSPENDED-no}
	if { [ "$service" = "mongodb" ] && [[ ! "$NOSQL_SERVICE_USER" =~ ^[A-Za-z0-9_]+$ ]]; } ||
		[[ ! "$NOSQL_SERVICE_PASSWORD" =~ ^[A-Za-z0-9]+$ ]] ||
		[[ ! "$NOSQL_SERVICE_PORT" =~ ^[0-9]+$ ]]; then
		check_result "$E_PARSING" "invalid $service service configuration"
	fi
	if [ "$NOSQL_SERVICE_STATUS" = "yes" ]; then
		check_result "$E_SUSPENDED" "$service is suspended"
	fi
	if [ "$service" = "redis" ] &&
		{ ! grep -Eq '^[[:space:]]*aclfile[[:space:]]+/etc/redis/users\.acl$' /etc/redis/redis.conf ||
			[ ! -f /etc/redis/users.acl ]; }; then
		check_result "$E_DISABLED" "Redis ACL persistence is not configured; run v-configure-sys-redis-acl as root"
	fi
}

nosql_random_password() {
	local password
	password=$(LC_ALL=C tr -dc 'A-Za-z0-9' < /dev/urandom | head -c 32)
	if [ "${#password}" -ne 32 ]; then
		check_result "$E_UPDATE" "failed to generate a NoSQL database password"
	fi
	printf '%s\n' "$password"
}

nosql_mongodb_eval() {
	local statement=$1
	local script
	local output
	local result

	script=$(mktemp) || check_result "$E_UPDATE" "failed to create a temporary MongoDB script"
	chmod 600 "$script"
	printf 'const client = new Mongo("mongodb://%s:%s@127.0.0.1:%s/admin?authSource=admin");\n%s\n' \
		"$NOSQL_SERVICE_USER" "$NOSQL_SERVICE_PASSWORD" "$NOSQL_SERVICE_PORT" "$statement" > "$script"
	output=$(mongosh --quiet --file "$script" 2>&1)
	result=$?
	rm -f "$script"
	if [ "$result" -ne 0 ]; then
		output=$(printf '%s' "$output" |
			sed -e "s/$NOSQL_SERVICE_PASSWORD/[redacted]/g" \
				-e "s/${NOSQL_NEW_PASSWORD:-__NO_PASSWORD__}/[redacted]/g")
		printf 'MongoDB operation failed: %s\n' "$output" >&2
		return "$result"
	fi
	return 0
}

nosql_redis_cli() {
	REDISCLI_AUTH="$NOSQL_SERVICE_PASSWORD" redis-cli -h 127.0.0.1 \
		-p "$NOSQL_SERVICE_PORT" --raw "$@"
}

nosql_redis_set_user() {
	local acl_user=$1
	local key_pattern=$2
	local password=$3
	local output
	output=$(printf '>%s' "$password" | REDISCLI_AUTH="$NOSQL_SERVICE_PASSWORD" \
		redis-cli -h 127.0.0.1 -p "$NOSQL_SERVICE_PORT" --raw -x ACL SETUSER \
		"$acl_user" reset on "~$key_pattern" +@read +@write +@fast +@connection -@admin -@dangerous \
		-scan -randomkey -dbsize)
	# Key patterns only guard commands that name keys: SCAN, RANDOMKEY and DBSIZE would show other
	# customers' key names/counts on the shared server, so they are denied.
	if [ "$?" -ne 0 ] || [ "$output" != "OK" ]; then
		printf 'Redis ACL update failed: %s\n' "$output" >&2
		return 1
	fi
	output=$(nosql_redis_cli ACL SAVE)
	if [ "$?" -ne 0 ] || [ "$output" != "OK" ]; then
		printf 'Redis ACL persistence failed: %s\n' "$output" >&2
		return 1
	fi
	return 0
}

nosql_redis_delete_keys() {
	local pattern=$1
	local cursor=0
	local output

	while :; do
		output=$(nosql_redis_cli EVAL \
			"local result=redis.call('SCAN',ARGV[1],'MATCH',ARGV[2],'COUNT',500); for _,key in ipairs(result[2]) do redis.call('DEL',key) end; return result[1]" \
			0 "$cursor" "$pattern")
		if [ "$?" -ne 0 ] || [[ ! "$output" =~ ^[0-9]+$ ]]; then
			printf 'Redis namespace cleanup failed: %s\n' "$output" >&2
			return 1
		fi
		cursor=$output
		[ "$cursor" = "0" ] && return 0
	done
}

nosql_append_record() {
	local type=$1
	local name=$2
	local database=$3
	local dbuser=$4
	local namespace=$5
	local time_n_date
	local time
	local date
	local file

	file=$(nosql_record_file "$type")
	touch "$file" || return 1
	chmod 660 "$file" || return 1
	time_n_date=$(date +'%T %F')
	time=${time_n_date%% *}
	date=${time_n_date#* }
	printf "NAME='%s' DATABASE='%s' DBUSER='%s' HOST='127.0.0.1' PORT='%s' NAMESPACE='%s' TIME='%s' DATE='%s'\n" \
		"$name" "$database" "$dbuser" "$NOSQL_SERVICE_PORT" "$namespace" "$time" "$date" >> "$file"
}

nosql_remove_record() {
	local type=$1
	local name=$2
	local file
	local temporary
	local result

	file=$(nosql_record_file "$type")
	temporary=$(mktemp "$USER_DATA/.nosql.XXXXXX") ||
		check_result "$E_UPDATE" "failed to update NoSQL database records"
	grep -Fv "NAME='$name' " "$file" > "$temporary"
	result=$?
	if [ "$result" -gt 1 ]; then
		rm -f "$temporary"
		return 1
	fi
	chmod 660 "$temporary" || {
		rm -f "$temporary"
		return 1
	}
	mv -f "$temporary" "$file" || {
		rm -f "$temporary"
		return 1
	}
}
