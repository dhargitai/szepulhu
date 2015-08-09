#!/bin/bash

if [ -z "$NGINX_SERVER_NAMES" ] ; then
    NGINX_SERVER_NAMES="szepul.hu www.szepul.hu"
fi
sed -i "s|\${NGINX_SERVER_NAMES}|${NGINX_SERVER_NAMES}|" /etc/nginx/sites-enabled/default

NGINX_INDEX_SCRIPT="app.php"
COMPOSER_INSTALL_MODE="--no-dev"
if [ "$APP_ENV" = "dev" ] ; then
    NGINX_INDEX_SCRIPT="app_dev.php"
    COMPOSER_INSTALL_MODE=""
fi
sed -i "s|\${NGINX_INDEX_SCRIPT}|${NGINX_INDEX_SCRIPT}|" /etc/nginx/sites-enabled/default

sed -i "s|;clear_env = no|clear_env = no|" /etc/php5/fpm/pool.d/www.conf

chown -R www-data: . && \
/wait-for-db.sh && \
rm -rf app/cache/* app/logs/* && \
su www-data -s /bin/bash -c "composer run-script post-install-cmd"

if [ "$APP_ENV" = "dev" ] && [[ -x "bin/phantomjs" ]]; then
    bin/phantomjs --webdriver=4444 &
fi

/sbin/my_init
