#!/bin/bash

echo
read -p "Enter your Github API token if you have any otherwise leave this blank [ENTER]: " githubapitoken
echo

echo
echo "Determining Docker IP..."
dockerip=$(ifconfig docker0 2> /dev/null | grep --word-regexp inet | awk '{print $2}' | sed 's%addr:%%g')
dockerinterfaceip=$dockerip
if [[ ! $dockerip =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]] ; then
    dockerip=$(docker-machine ip default 2> /dev/null)
    if [[ ! $dockerip =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]] ; then
        echo "Can't determine Docker's IP address"
        exit -1
    fi
    subnet=${dockerip%.*}
    dockerinterfaceip=$(ifconfig 2> /dev/null | grep -F "inet $subnet" | awk '{print $2}' | sed 's%addr:%%g')
fi

echo
echo "Writing environment file..."
echo "APP_ENV=dev
APP_DEBUG=1
MYSQL_USER=dev
MYSQL_PASSWORD=123pass
MYSQL_ROOT_PASSWORD=supersecret
MYSQL_DATABASE=szepulhu_db
DOCKER_IP=$dockerip
DOCKER_INTERFACE_IP=$dockerinterfaceip
GITHUB_API_TOKEN=$githubapitoken
XDG_CONFIG_HOME=/tmp/www-data/.config
XDG_CACHE_HOME=/tmp/www-data/.cache
XDG_DATA_HOME=/tmp/www-data/.data
XDG_STATE_HOME=/tmp/www-data/.state
COMPOSER_HOME=/tmp/www-data/
NPM_CONFIG_PREFIX=/tmp/www-data" > .env

echo
echo "Writing PHP config file..."
echo "; XDebug configuration
xdebug.remote_enable = 1
xdebug.renite_enable = 1
xdebug.max_nesting_level = 1000
xdebug.profiler_enable_trigger = 1
xdebug.profiler_output_dir = \"/var/log\"
xdebug.default_enable = 1
xdebug.remote_autostart = 0
xdebug.remote_handler = dbgp
xdebug.remote_port = 9000
xdebug.remote_connect_back = Off
xdebug.remote_host = $dockerinterfaceip

cgi.fix_pathinfo = 0
date.timezone = \"Europe/Budapest\"" > docker/services/php5-fpm/php.ini

echo
host_entry="$dockerip szepul.hu.dev szepul.hu.test"
if grep "$host_entry" /etc/hosts;
then
    echo "Your hosts file is up to date."
else
    echo "Adding szepul.hu.dev and szepul.hu.test domains to your hosts file..."
    echo $host_entry | sudo tee -a /etc/hosts
fi

echo
echo "Ok, your files are ready. From now you can use build.sh to build up your environment."
