#!/usr/bin/env bash
set -euo pipefail

# Default PORT for local if not provided by platform
: "${PORT:=8080}"

# Configure Apache to listen on provided PORT
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf || true
sed -i "s#<VirtualHost \*:80>#<VirtualHost *:${PORT}>#" /etc/apache2/sites-available/000-default.conf || true
\
    a2enmod rewrite >/dev/null 2>&1 || true

# Ensure correct permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rw storage bootstrap/cache

# Optimize Laravel
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run migrations (safe in idempotent manner). Set RUN_MIGRATIONS=false to skip
if [[ "${RUN_MIGRATIONS:-true}" == "true" ]]; then
  php artisan migrate --force || true
fi

# Start Apache in foreground
exec apache2-foreground
