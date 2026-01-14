#!/bin/sh

# Replace PORT placeholder in nginx config
envsubst '${PORT}' < /app/nginx.template.conf > /tmp/nginx.conf

# Find PHP-FPM binary (try different names)
if command -v php-fpm >/dev/null 2>&1; then
    PHP_FPM="php-fpm"
elif command -v php-fpm8.2 >/dev/null 2>&1; then
    PHP_FPM="php-fpm8.2"
elif command -v php-fpm82 >/dev/null 2>&1; then
    PHP_FPM="php-fpm82"
else
    echo "PHP-FPM not found, falling back to PHP built-in server"
    exec php -S 0.0.0.0:$PORT -t /app/public
fi

# Start PHP-FPM in background (allow root with -R flag)
$PHP_FPM -y /app/php-fpm.conf -R -F &

# Wait for PHP-FPM to start
sleep 2

# Start Nginx in foreground
nginx -c /tmp/nginx.conf -g 'daemon off;'
