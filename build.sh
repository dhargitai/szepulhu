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
rm -rf  application/app/Resources/public/css/foundation \
        application/web/uploads/media/* \
        application/web/css/* \
        application/web/js/* \
        application/src/Application/DataFixtures/data

docker build -t szepulhu_web .

./start.sh

echo ""
echo "For the first time we also have to generate fixtures, so we need even more patience..."
./wait-for-webserver.sh

docker exec -it szepulhu_web_1 su www-data -s /bin/bash -c '
    composer install --ansi --prefer-dist --no-interaction && \
    php app/console doctrine:database:drop --force && \
    php app/console doctrine:database:create && \
    wget https://www.dropbox.com/s/ty3soyfivprjcp4/szepul.hu.fixtures.files.tar.gz?dl=0 -O /tmp/fixtures.tar.gz && \
    tar -xzf /tmp/fixtures.tar.gz --no-same-owner -C src/Application/DataFixtures/ && \
    mkdir -p web/uploads/media && \
    php app/console szepulhu:fixtures:load
'

cd application/app/Resources/public && \
    npm install && \
    node_modules/.bin/bower --config.interactive=false --allow-root install && \
    cp -R bower_components/foundation/scss css/foundation && \
    mv css/foundation/normalize.scss css/foundation/_normalize.scss && \
    node_modules/.bin/gulp build && \
cd ../../../../

echo ""
echo "Ok, done! Let's work!"
