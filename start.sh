#!/bin/bash

environment=dev

while getopts ":e:h" opt; do
  case ${opt} in
    e )
      environment=$OPTARG
      ;;
    h )
      echo "Usage:"
      echo "    $0 -h                       Display help"
      echo "    $0 -e <docker-environment>  Set container environment. Defaults to \"dev\""
      exit 0
      ;;
    \? )
      echo "Invalid option: $OPTARG" 1>&2
      exit 1
      ;;
    : )
      echo "Invalid option: $OPTARG requires an argument" 1>&2
      exit 2
      ;;
  esac
done
shift $((OPTIND -1))

echo "Starting application in $environment environment."

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

if [ $(docker ps -a | grep szepulhu_web_1 | wc -l) -eq 1 ] && $(docker inspect szepulhu_web_1 | grep -q APP_ENV="$environment")
then
  docker start szepulhu_web_1
  docker exec -it szepulhu_web_1 su www-data -s /bin/bash -c 'composer run-script post-update-cmd'
else
  if [ $(docker ps -a | grep szepulhu_web_1 | wc -l) -eq 1 ]; then
    docker rm -f szepulhu_web_1
  fi
  docker run --name szepulhu_web_1 \
             --link szepulhu_mysql:db \
             --add-host szepul.hu.test:127.0.0.1 \
             --add-host szepul.hu.dev:127.0.0.1 \
             -v $(pwd)/application:/var/www/szepul.hu \
             -e APP_ENV="$environment" \
             -e APP_DEBUG=1 \
             -e NGINX_SERVER_NAMES="szepul.hu.dev www.szepul.hu.dev" \
             -h web1.szepul.hu.dev \
             -p 80:80 -d \
           szepulhu_web
fi

echo ""
echo "The containers has been started. Please be patient as clearing the Symfony cache could take some time..."
echo "Once it's done you should see the site at http://szepul.hu.dev"
