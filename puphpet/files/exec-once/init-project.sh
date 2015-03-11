#!/bin/bash
echo "cd /var/www/szepul.hu" >> /home/vagrant/.bash_profile
cd /var/www/szepul.hu
rm -rf app/cache/*
rm -rf app/logs/*
/usr/local/bin/composer install
app/console doctrine:schema:create
app/console doctrine:fixtures:load --no-interaction
app/console assets:install --symlink
app/console assetic:dump
