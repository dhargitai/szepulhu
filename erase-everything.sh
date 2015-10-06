#!/bin/bash

export $(cat .env | grep -v ^# | xargs)

echo "Deleting all related Docker containers and images..."
if [ $(docker ps -a | grep szepulhu_mysql | wc -l) -eq 1 ]; then
    docker exec -it szepulhu_mysql /bin/bash -c "
        mysql -uroot -p$MYSQL_ROOT_PASSWORD << EOF
DROP DATABASE IF EXISTS $MYSQL_DATABASE;
EOF
"
fi

echo "Deleting all related Docker containers and images..."
docker-compose stop web && docker-compose rm -f web
docker-compose stop database && docker-compose rm -f database
if [ $(docker images | grep szepulhu_web | wc -l) -eq 1 ]; then
    docker rmi -f szepulhu_web
fi

echo "Removing project from hosts file..."
if [ $EUID != 0 ]; then
    grep -v "$DOCKER_IP szepul.hu.dev szepul.hu.test" /etc/hosts > temp && sudo mv temp /etc/hosts
fi

echo "Done."
