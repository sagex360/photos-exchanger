#!/bin/bash

cd /var/www/

composer install
php artisan key:generate
php artisan migrate:fresh
php artisan storage:link

exec "$@"
