#!/bin/bash

if [ $(docker ps -a | grep szepulhu_mysql | wc -l) -eq 1 ]; then
  docker rm -f szepulhu_mysql
fi
if [ $(docker ps -a | grep szepulhu_web_1 | wc -l) -eq 1 ]; then
  docker rm -f szepulhu_web_1
fi
if [ $(docker images | grep szepulhu_web | wc -l) -eq 1 ]; then
  docker rmi -f szepulhu_web
fi
if [ $(docker ps -a | grep szepulhu_dataonly_mysql | wc -l) -eq 0 ]; then
  docker create --name szepulhu_dataonly_mysql arungupta/mysql-data-container
fi
rm -rf  application/web/uploads/media/* \
        application/web/css/* \
        application/web/js/* \
        application/src/Application/DataFixtures/data

docker build -t szepulhu_web .

# Start the application in build environment
./start.sh -e build

echo ""
echo "For the first time we also have to generate fixtures, so we need even more patience..."
./wait-for-webserver.sh

docker exec -it szepulhu_web_1 su www-data -s /bin/bash -c '
    export HOME=/tmp/www-data XDG_CONFIG_HOME=/tmp/www-data/.config XDG_CACHE_HOME=/tmp/www-data/.cache XDG_DATA_HOME=/tmp/www-data/.data XDG_STATE_HOME=/tmp/www-data/.state && \
    composer install --ansi --prefer-dist --no-interaction && \
    php app/console doctrine:database:drop --force && \
    php app/console doctrine:database:create && \
    wget https://www.dropbox.com/s/ty3soyfivprjcp4/szepul.hu.fixtures.files.tar.gz?dl=0 -O /tmp/fixtures.tar.gz && \
    tar -xzf /tmp/fixtures.tar.gz --no-same-owner -C src/Application/DataFixtures/ && \
    mkdir -p web/uploads/media && \
    php app/console szepulhu:fixtures:load && \
    php app/console fos:js-routing:dump && \
    cd app/Resources/public && \
    npm install && \
    node_modules/.bin/bower --config.interactive=false install && \
    node_modules/.bin/gulp build
'

# Start the application in the default environment
./stop.sh
./start.sh

echo ""
echo "Ok, done! Let's work!"
