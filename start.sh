#!/bin/bash

if [ $(docker ps -a | grep szepulhu_mysql | wc -l) -eq 1 ]; then
  docker start szepulhu_mysql
else
  docker run --name szepulhu_mysql \
             --volumes-from szepulhu_dataonly_mysql \
             -v /var/lib/mysql:/var/lib/mysql \
             -e MYSQL_USER=dev \
             -e MYSQL_PASSWORD=dev123 \
             -e MYSQL_DATABASE=szepulhu_db \
             -e MYSQL_ROOT_PASSWORD=supersecret \
             -h db1.szepul.hu.dev \
             -P -d \
           mysql
fi

if [ $(docker ps -a | grep szepulhu_web_1 | wc -l) -eq 1 ]; then
  docker start szepulhu_web_1
else
  docker run --name szepulhu_web_1 \
             --link szepulhu_mysql:db \
             --add-host szepul.hu.test:127.0.0.1 \
             --add-host szepul.hu.dev:127.0.0.1 \
             -v $(pwd)/application:/var/www/szepul.hu \
             -e APP_ENV=dev \
             -e APP_DEBUG=1 \
             -e NGINX_SERVER_NAMES="szepul.hu.dev www.szepul.hu.dev" \
             -h web1.szepul.hu.dev \
             -p 80:80 -d \
           szepulhu_web
fi

echo ""
echo "The containers has been started. Please be patient as clearing the Symfony cache could take some time..."
echo "Once it's done you should see the site at http://szepul.hu.dev"
