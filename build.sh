#!/bin/bash

export $(cat .env | grep -v ^# | xargs)

docker-compose up -d --force-recreate

./wait-for-webserver.sh

echo
echo "Removing generated project assets..."
rm -rf  application/web/uploads/media/* \
        application/web/css/* \
        application/web/js/* \
        application/src/Application/DataFixtures/data

echo
echo "Checking if compressed fixture media file exists and fresh..."
FIXTURE_MEDIA_LOCAL_FILE="application/app/build/fixtures.media.tar.gz"
FIXTURE_MEDIA_LOCAL_FILE_SIZE=$([ -f $FIXTURE_MEDIA_LOCAL_FILE ] && echo $(wc -c $FIXTURE_MEDIA_LOCAL_FILE 2>/dev/null | awk '{print $1}' | tr -d '[[:space:]]') || echo 0)
FIXTURE_MEDIA_REMOTE_FILE="https://s3.eu-central-1.amazonaws.com/szepulhudevelopment/fixtures.media.tar.gz"
FIXTURE_MEDIA_REMOTE_FILE_SIZE=$(curl -sI $FIXTURE_MEDIA_REMOTE_FILE | grep -i content-length | awk '{print $2}' | tr -d '[[:space:]]')
if [ "$FIXTURE_MEDIA_LOCAL_FILE_SIZE" -ne "$FIXTURE_MEDIA_REMOTE_FILE_SIZE" ]; then
    echo
    echo "Compressed fixture media file doesn't exists or stale. Downloading new file..."
    rm -rf $FIXTURE_MEDIA_LOCAL_FILE 2>/dev/null
    mkdir -p application/app/build
    wget $FIXTURE_MEDIA_REMOTE_FILE -O $FIXTURE_MEDIA_LOCAL_FILE
fi
echo
echo "Extracting fixture media files..."
tar -xzf $FIXTURE_MEDIA_LOCAL_FILE --no-same-owner -C application/src/Application/DataFixtures/

echo
echo "Setting up permissions to the database..."
docker exec -it szepulhu_mysql /bin/bash -c "
    mysql -uroot -p$MYSQL_ROOT_PASSWORD << EOF
GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* To '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';
GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* To '$MYSQL_USER'@'localhost' IDENTIFIED BY '$MYSQL_PASSWORD';
DROP DATABASE IF EXISTS $MYSQL_DATABASE;
EOF
"

if [ -n "$GITHUB_API_TOKEN" ]; then
    echo
    echo "Configuring Composer to use your Github API token..."
    COMPOSER_CONFIG_COMMAND="composer config -g github-oauth.github.com $GITHUB_API_TOKEN"
    docker exec -it szepulhu_web_1 su www-data -s /bin/bash -c "$COMPOSER_CONFIG_COMMAND"
fi

docker exec -it szepulhu_web_1 su www-data -s /bin/bash -c '
    chown -R www-data: .
    composer install --ansi --prefer-dist --no-interaction && \
    composer run-script post-build-cmd && \
    bin/phantomjs --webdriver=4444 & \
    mkdir -p web/uploads/media && \
    php app/console doctrine:database:create && \
    php app/console szepulhu:fixtures:load && \
    php app/console fos:js-routing:dump && \
    cp -R app/Resources/public/* app/build/ && \
    cd app/build/ && \
    npm install && \
    node_modules/.bin/bower --config.interactive=false install && \
    node_modules/.bin/gulp build
'

echo
echo "Ok, done! Let's work!"
