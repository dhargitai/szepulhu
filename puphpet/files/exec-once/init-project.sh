#!/bin/bash
cd /var/www
app/console doctrine:schema:create
app/console doctrine:fixtures:load --no-interaction
app/console assets:install --symlink
app/console cache:clear
app/console assetic:dump
