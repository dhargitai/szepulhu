#!/bin/sh
echo "Waiting for the webserver..."

until [ "`docker exec szepulhu_web_1 /bin/sh -c 'service nginx status'`" == "nginx is running." ]; do
    printf "."
    sleep 2;
done;
echo " Got it!"
