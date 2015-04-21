#!/bin/bash

docker build -t szepulhu_web .
docker create --name szepulhu_mysql_data arungupta/mysql-data-container

./start.sh

echo ""
echo "For the first time we also have to generate fixtures, so we need even more patience..."
./wait-for-webserver.sh

docker run --link szepulhu_mysql:db \
           -v $(pwd)/application:/var/www/szepul.hu \
           -e APP_ENV=dev \
           -e APP_DEBUG=1 \
           -e NGINX_SERVER_NAMES="szepul.hu.dev www.szepul.hu.dev" \
           --rm \
         szepulhu_web /bin/sh -c '
            bin/wait-for-db.sh && \
            composer install --ansi --prefer-dist --no-interaction && \
            php app/console doctrine:database:drop --force && \
            php app/console doctrine:database:create && \
            php app/console doctrine:schema:create && \
            wget https://www.dropbox.com/s/ty3soyfivprjcp4/szepul.hu.fixtures.files.tar.gz?dl=0 -O /tmp/fixtures.tar.gz && \
            tar -xzf /tmp/fixtures.tar.gz --no-same-owner -C src/Application/DataFixtures/ && \
            mkdir -p web/uploads/media && \
            php app/console doctrine:fixtures:load --no-interaction && \
            cd app/Resources/public && bower --config.interactive=false --allow-root install && cd ../../.. && \
            cp -R app/Resources/public/bower_components/foundation/scss app/Resources/public/css/foundation && \
            mv app/Resources/public/css/foundation/normalize.scss app/Resources/public/css/foundation/_normalize.scss
            php app/console assetic:dump
         '

echo ""
echo "Ok, done! Let's work!"
