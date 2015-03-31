#!/bin/bash

if [ ! -n "$NGINX_SERVER_NAMES" ] ; then
    NGINX_SERVER_NAMES="szepul.hu www.szepul.hu"
fi
sed -i "s|\${NGINX_SERVER_NAMES}|${NGINX_SERVER_NAMES}|" /etc/nginx/sites-enabled/szepul.hu.conf

NGINX_INDEX_SCRIPT="app.php"
COMPOSER_INSTALL_MODE="--no-dev"
if [ "$APP_ENV" = "dev" ] ; then
    NGINX_INDEX_SCRIPT="app_dev.php"
    COMPOSER_INSTALL_MODE="--dev"
fi
sed -i "s|\${NGINX_INDEX_SCRIPT}|${NGINX_INDEX_SCRIPT}|" /etc/nginx/sites-enabled/szepul.hu.conf

bin/wait-for-db.sh && \
rm -rf app/cache/* app/logs/* && \
composer install --prefer-dist $COMPOSER_INSTALL_MODE

/usr/bin/supervisord
