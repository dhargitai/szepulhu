#!/bin/sh

#
# Following commands expected to run with root privileges
#
echo; echo "Trying to set up file permissions..." &&
chown -R www-data: /var/www/szepul.hu

#su www-data -s /bin/bash

#
# Following commands expected to run as www-data user
#
echo; echo "Removing generated project assets..."
rm -rf  web/uploads/media/* \
        src/Application/DataFixtures/data

echo; echo "Checking if compressed fixture media file exists and fresh..."
FIXTURE_MEDIA_LOCAL_FILE="/tmp/fixtures.media.tar.gz"
FIXTURE_MEDIA_LOCAL_FILE_SIZE=$([ -f $FIXTURE_MEDIA_LOCAL_FILE ] && echo $(wc -c $FIXTURE_MEDIA_LOCAL_FILE 2>/dev/null | awk '{print $1}' | tr -d '[[:space:]]') || echo 0)
FIXTURE_MEDIA_REMOTE_FILE="http://188.166.163.97:8000/fixtures.media.tar.gz"
FIXTURE_MEDIA_REMOTE_FILE_SIZE=$(curl -sI $FIXTURE_MEDIA_REMOTE_FILE | grep -i content-length | awk '{print $2}' | tr -d '[[:space:]]')
if [ "$FIXTURE_MEDIA_LOCAL_FILE_SIZE" -ne "$FIXTURE_MEDIA_REMOTE_FILE_SIZE" ]; then
    echo; echo "Compressed fixture media file doesn't exists or stale. Downloading new file..."
    rm -rf $FIXTURE_MEDIA_LOCAL_FILE 2>/dev/null
    wget $FIXTURE_MEDIA_REMOTE_FILE -O $FIXTURE_MEDIA_LOCAL_FILE
fi
echo; echo "Extracting fixture media files..."
tar -xzf $FIXTURE_MEDIA_LOCAL_FILE --no-same-permissions --no-same-owner -C src/Application/DataFixtures/



echo; echo "Creating media upload folder..." &&
mkdir -p web/uploads/media
php app/console doctrine:database:drop --force
php app/console doctrine:database:create &&
php app/console szepulhu:fixtures:load &&
php app/console fos:js-routing:dump &&

exit 0
