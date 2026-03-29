#!/usr/bin/env bash

set -euo pipefail

BASE_DIR="${TMPDIR:-/tmp}/forto-mysql"
SOCKET_FILE="$BASE_DIR/mysql.sock"
PID_FILE="$BASE_DIR/mysql.pid"

pick_bin() {
    for candidate in "$@"; do
        if command -v "$candidate" >/dev/null 2>&1; then
            echo "$candidate"
            return 0
        fi
    done

    return 1
}

MYSQL_ADMIN_BIN="$(pick_bin mariadb-admin mysqladmin)"

if [[ -S "$SOCKET_FILE" ]]; then
    if "$MYSQL_ADMIN_BIN" --protocol=socket --socket="$SOCKET_FILE" -uroot shutdown >/dev/null 2>&1; then
        echo "MySQL lokal berhasil dimatikan"
        exit 0
    fi
fi

if [[ -f "$PID_FILE" ]] && kill -0 "$(cat "$PID_FILE")" 2>/dev/null; then
    kill "$(cat "$PID_FILE")"
    echo "MySQL lokal dimatikan lewat PID file"
    exit 0
fi

echo "MySQL lokal tidak sedang berjalan"
