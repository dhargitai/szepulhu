#!/bin/bash
echo "cd /var/www/szepul.hu" >> /home/vagrant/.bash_profile
wget -nv https://www.dropbox.com/s/ty3soyfivprjcp4/szepul.hu.fixtures.files.tar.gz?dl=0 -O /tmp/fixtures.tar.gz
cd /var/www/szepul.hu
sudo npm install -g bower &>npm-install.log

cd app/Resources/public
bower --config.interactive=false --allow-root install
cd /var/www/szepul.hu

rm -rf app/cache/*
rm -rf app/logs/*
/usr/local/bin/composer install
app/console doctrine:schema:create

cd src/Application/DataFixtures/
tar -xzf /tmp/fixtures.tar.gz --owner vagrant --group www-data --no-same-owner
cd /var/www/szepul.hu
app/console doctrine:fixtures:load --no-interaction

app/console assets:install --symlink
app/console assetic:dump
