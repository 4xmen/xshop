#!/usr/bin/env bash
# Prepares the app on container start: .env, APP_KEY, storage perms,
# database wait + migrate/seed, caches, then hands over to the CMD.
set -euo pipefail

cd /var/www/html
log() { echo "[entrypoint] $*"; }

# behaviour flags (overridable via -e / compose environment)
export RUN_QUEUE_WORKER="${RUN_QUEUE_WORKER:-true}"
export RUN_SCHEDULER="${RUN_SCHEDULER:-true}"
export QUEUE_WORKERS="${QUEUE_WORKERS:-1}"
AUTO_MIGRATE="${AUTO_MIGRATE:-true}"
AUTO_SEED="${AUTO_SEED:-false}"
WAIT_FOR_DB="${WAIT_FOR_DB:-true}"
OPTIMIZE="${OPTIMIZE:-true}"

# image has no dev deps -> must run as production (dev providers would crash)
export APP_ENV=production
export APP_DEBUG="${APP_DEBUG:-false}"

# fallback .env (real env vars still take precedence)
[ -f .env ] || { log "creating .env from .env.example"; cp .env.example .env; }

# recreate storage layout (matters when storage is a fresh volume)
mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/testing \
    storage/logs \
    storage/app/public \
    storage/media-library/temp \
    bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R ug+rwx storage bootstrap/cache || true

# generate APP_KEY once, export it so the workers see the same key
if [ -z "${APP_KEY:-}" ] && ! grep -qE '^APP_KEY=base64:' .env 2>/dev/null; then
    log "generating application key"
    APP_KEY="$(php artisan key:generate --show)"
    export APP_KEY
    if grep -qE '^APP_KEY=' .env; then
        sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
    else
        echo "APP_KEY=${APP_KEY}" >> .env
    fi
elif [ -z "${APP_KEY:-}" ]; then
    export APP_KEY="$(grep -E '^APP_KEY=' .env | head -n1 | cut -d= -f2-)"
fi

# sqlite: make sure the file exists
DB_CONNECTION="${DB_CONNECTION:-sqlite}"
if [ "${DB_CONNECTION}" = "sqlite" ]; then
    DB_DATABASE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    mkdir -p "$(dirname "${DB_DATABASE}")"
    [ -f "${DB_DATABASE}" ] || { touch "${DB_DATABASE}"; chown www-data:www-data "${DB_DATABASE}"; }
fi

# wait for a networked database before migrating
wait_for_db() {
    local host="${DB_HOST:-}" port="${DB_PORT:-3306}"
    [ -z "${host}" ] && return 0
    log "waiting for database at ${host}:${port}"
    for i in $(seq 1 60); do
        if php -r '$c=@fsockopen($argv[1],(int)$argv[2]); exit($c?0:1);' "${host}" "${port}" 2>/dev/null; then
            log "database is reachable"
            return 0
        fi
        sleep 2
    done
    log "WARNING: database not reachable after timeout, continuing"
}
case "${DB_CONNECTION}" in
    mysql|mariadb|pgsql) [ "${WAIT_FOR_DB}" = "true" ] && wait_for_db ;;
esac

if [ "${AUTO_MIGRATE}" = "true" ]; then
    log "running migrations"
    php artisan migrate --force --no-interaction || log "WARNING: migrations failed"
fi
if [ "${AUTO_SEED}" = "true" ]; then
    log "seeding database"
    php artisan db:seed --force --no-interaction || log "WARNING: seeding failed"
fi

php artisan storage:link --force >/dev/null 2>&1 || true

# cache config/routes/views using the live env
php artisan config:clear >/dev/null 2>&1 || true
if [ "${OPTIMIZE}" = "true" ]; then
    log "caching config, routes and views"
    php artisan config:cache >/dev/null 2>&1 || log "WARNING: config:cache failed"
    php artisan route:cache  >/dev/null 2>&1 || true
    php artisan view:cache   >/dev/null 2>&1 || true
fi

# artisan ran as root above; hand storage back to www-data
chown -R www-data:www-data storage bootstrap/cache || true

log "startup complete -> $*"
exec "$@"
