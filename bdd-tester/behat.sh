#!/usr/bin/env sh

if [ "$APP_XDEBUG" == 1 ] && [ ! -z $DOCKER_IP ]; then
    sed -i "s/%remote_host%/$DOCKER_IP/" /etc/php7/conf.d/xdebug.ini
    export XDEBUG_CONFIG="idekey=phpstorm"
    echo "Xdebug is enabled."
else
    [ -f /etc/php7/conf.d/xdebug.ini ] && rm /etc/php7/conf.d/xdebug.ini
    echo "Xdebug is disabled."
fi

behat --colors "$@"
