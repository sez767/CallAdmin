#!/usr/bin/env bash  

# composer install
# php artisan migrate --force
php artisan queue:work redis --tries=3