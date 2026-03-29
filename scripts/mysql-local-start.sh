#!/usr/bin/env bash

set -euo pipefail

BASE_DIR="${TMPDIR:-/tmp}/forto-mysql"
DATA_DIR="$BASE_DIR/data"
SOCKET_FILE="$BASE_DIR/mysql.sock"
PID_FILE="$BASE_DIR/mysql.pid"
LOG_FILE="$BASE_DIR/mysql.log"
PORT="${MYSQL_LOCAL_PORT:-3307}"

pick_bin() {
    for candidate in "$@"; do
        if command -v "$candidate" >/dev/null 2>&1; then
            echo "$candidate"
            return 0
        fi
    done

    return 1
}

MYSQL_INSTALL_BIN="$(pick_bin mariadb-install-db mysql_install_db)"
MYSQL_SERVER_BIN="$(pick_bin mariadbd mysqld)"
MYSQL_CLIENT_BIN="$(pick_bin mariadb mysql)"
MYSQL_ADMIN_BIN="$(pick_bin mariadb-admin mysqladmin)"

mkdir -p "$BASE_DIR"

if [[ -f "$PID_FILE" ]] && kill -0 "$(cat "$PID_FILE")" 2>/dev/null; then
    echo "MySQL lokal sudah berjalan di port $PORT"
    exit 0
fi

rm -f "$PID_FILE" "$SOCKET_FILE"

if [[ ! -d "$DATA_DIR/mysql" ]]; then
    "$MYSQL_INSTALL_BIN" \
        --no-defaults \
        --datadir="$DATA_DIR" \
        --auth-root-authentication-method=normal \
        --skip-test-db
fi

nohup "$MYSQL_SERVER_BIN" \
    --no-defaults \
    --datadir="$DATA_DIR" \
    --socket="$SOCKET_FILE" \
    --pid-file="$PID_FILE" \
    --log-error="$LOG_FILE" \
    --port="$PORT" \
    --bind-address=127.0.0.1 \
    --skip-networking=0 \
    >/dev/null 2>&1 < /dev/null &

for _ in $(seq 1 30); do
    if "$MYSQL_ADMIN_BIN" --protocol=socket --socket="$SOCKET_FILE" -uroot ping >/dev/null 2>&1; then
        "$MYSQL_CLIENT_BIN" --protocol=socket --socket="$SOCKET_FILE" -uroot <<'SQL'
CREATE DATABASE IF NOT EXISTS forto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS forto_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'forto_user'@'127.0.0.1' IDENTIFIED BY 'forto_pass_123';
CREATE USER IF NOT EXISTS 'forto_user'@'localhost' IDENTIFIED BY 'forto_pass_123';
GRANT ALL PRIVILEGES ON forto.* TO 'forto_user'@'127.0.0.1';
GRANT ALL PRIVILEGES ON forto_test.* TO 'forto_user'@'127.0.0.1';
GRANT ALL PRIVILEGES ON forto.* TO 'forto_user'@'localhost';
GRANT ALL PRIVILEGES ON forto_test.* TO 'forto_user'@'localhost';
FLUSH PRIVILEGES;
SQL

        echo "MySQL lokal siap di port $PORT"
        echo "Socket: $SOCKET_FILE"
        exit 0
    fi

    sleep 1
done

echo "MySQL lokal gagal start. Cek log di $LOG_FILE" >&2
exit 1
