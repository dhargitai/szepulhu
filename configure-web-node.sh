#!/usr/bin/env bash

#
# Following commands expected to run with root privileges
#
echo; echo "Trying to set up file permissions..." &&
chown -R www-data: .

su www-data -s /bin/bash

#
# Following commands expected to run as www-data user
#
echo; echo "Removing generated project assets..."
rm -rf  web/uploads/media/* \
        web/css/* \
        web/js/* \
        src/Application/DataFixtures/data

echo; echo "Checking if compressed fixture media file exists and fresh..."
FIXTURE_MEDIA_LOCAL_FILE="app/build/fixtures.media.tar.gz"
FIXTURE_MEDIA_LOCAL_FILE_SIZE=$([ -f $FIXTURE_MEDIA_LOCAL_FILE ] && echo $(wc -c $FIXTURE_MEDIA_LOCAL_FILE 2>/dev/null | awk '{print $1}' | tr -d '[[:space:]]') || echo 0)
FIXTURE_MEDIA_REMOTE_FILE="https://s3.eu-central-1.amazonaws.com/szepulhudevelopment/fixtures.media.tar.gz"
FIXTURE_MEDIA_REMOTE_FILE_SIZE=$(curl -sI $FIXTURE_MEDIA_REMOTE_FILE | grep -i content-length | awk '{print $2}' | tr -d '[[:space:]]')
if [ "$FIXTURE_MEDIA_LOCAL_FILE_SIZE" -ne "$FIXTURE_MEDIA_REMOTE_FILE_SIZE" ]; then
    echo; echo "Compressed fixture media file doesn't exists or stale. Downloading new file..."
    rm -rf $FIXTURE_MEDIA_LOCAL_FILE 2>/dev/null
    mkdir -p app/build
    wget --progress=bar:force $FIXTURE_MEDIA_REMOTE_FILE -O $FIXTURE_MEDIA_LOCAL_FILE
fi
echo; echo "Extracting fixture media files..."
tar -xzf $FIXTURE_MEDIA_LOCAL_FILE --no-same-permissions --no-same-owner -C src/Application/DataFixtures/

if [ -n "$GITHUB_API_TOKEN" ]; then
    echo; echo "Configuring Composer to use your Github API token..."
    composer config -g github-oauth.github.com $GITHUB_API_TOKEN
fi

echo; echo "Installing composer packages..." &&
composer install --ansi --prefer-dist --no-interaction &&

echo; echo "Installing PhantomJS..." &&
composer run-script post-build-cmd &&

echo; echo "Creating media upload folder..." &&
mkdir -p web/uploads/media &&
php app/console doctrine:database:create &&
php app/console szepulhu:fixtures:load &&
php app/console fos:js-routing:dump &&

echo; echo "Collecting and installing frontend dependecies..." &&
cp -R app/Resources/public/* app/build/ &&
cd app/build/ &&
npm install &&
node_modules/.bin/bower --config.interactive=false install &&
node_modules/.bin/gulp build

exit 0

#
# Following commands expected to run with root privileges
#
echo; echo "Installing PhantomJS system service..." &&
mkdir -p /etc/service/phantomjs &&
tee /etc/service/phantomjs/run > /dev/null << EOL
#!/usr/bin/env bash

exec /sbin/setuser www-data /var/www/szepul.hu/bin/phantomjs --webdriver=4444 >>/var/log/phantomjs.log 2>&1
EOL
chmod u+x /etc/service/phantomjs/run