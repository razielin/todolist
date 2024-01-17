#!/bin/sh

cd /var/www/html

APP_ENV=prod COMPOSER_HOME=/root /usr/bin/composer install --no-cache --optimize-autoloader --no-dev \
    && php bin/console doctrine:migrations:migrate --no-interaction --env=prod \
    && chown -R www-data:www-data ./var