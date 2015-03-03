#!/bin/bash
cd /var/www
bin/composer.phar install
app/console doctrine:schema:create
app/console doctrine:fixtures:load --no-interaction
app/console assets:install --symlink
app/console assetic:dump
