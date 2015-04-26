#!/bin/bash

./stop.sh

docker run --name szepulhu_mysql \
           --volumes-from szepulhu_mysql_data \
           -v /var/lib/mysql:/var/lib/mysql \
           -e MYSQL_USER=dev \
           -e MYSQL_PASSWORD=dev123 \
           -e MYSQL_DATABASE=szepulhu_db \
           -e MYSQL_ROOT_PASSWORD=supersecret \
           -P -d \
         mysql

docker run --name szepulhu_web_1 \
           --link szepulhu_mysql:db \
           -v $(pwd)/application:/var/www/szepul.hu \
           -e APP_ENV=dev \
           -e APP_DEBUG=1 \
           -e NGINX_SERVER_NAMES="szepul.hu.dev www.szepul.hu.dev" \
           -p 80:80 -d \
         szepulhu_web

echo ""
echo "The containers has been started. Please be patient as clearing the Symfony cache could take some time..."
echo "Once it's done you should see the site at http://szepul.hu.dev"
