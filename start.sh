#!/bin/sh

# Replace PORT placeholder in nginx config
envsubst '${PORT}' < /app/nginx.template.conf > /tmp/nginx.conf

# Start PHP-FPM in background
php-fpm82 -y /app/php-fpm.conf -F &

# Wait for PHP-FPM to start
sleep 2

# Start Nginx in foreground
nginx -c /tmp/nginx.conf -g 'daemon off;'
