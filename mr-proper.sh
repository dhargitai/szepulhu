#!/bin/bash

usage() { echo "Usage: $0 [-h] [-d <szepulhu_mysql>] [-w <szepulhu_web_1>] [-c <docker-compose.yml>]" 1>&2; exit 1; }

docker_image_mysql='szepulhu_mysql'
docker_image_web='szepulhu_web_1'
docker_compose_config='docker-compose.yml'
while getopts ":d:w:c:h" o; do
    case "${o}" in
        d)
            docker_image_mysql=${OPTARG}
            ;;
        w)
            docker_image_web=${OPTARG}
            ;;
        c)
            docker_compose_config=${OPTARG}
            ;;
        *)
            usage
            ;;
    esac
done
shift $((OPTIND-1))

export $(cat .env | grep -v ^# | xargs)

echo "Deleting all related Docker containers and images..."
if [ $(docker ps -a | grep "$docker_image_mysql" | wc -l) -eq 1 ]; then
    docker exec -it "$docker_image_mysql" /bin/bash -c "
        mysql -uroot -p$MYSQL_ROOT_PASSWORD << EOF
DROP DATABASE IF EXISTS $MYSQL_DATABASE;
EOF
"
fi

echo "Deleting all related Docker containers and images..."
docker-compose -f "$docker_compose_config" stop web && docker-compose rm -f web
docker-compose -f "$docker_compose_config" stop database && docker-compose rm -f database
if [ $(docker images | grep "$docker_image_web" | wc -l) -eq 1 ]; then
    docker rmi -f "$docker_image_web"
fi

echo "Removing project from hosts file..."
if [ $EUID != 0 ] && [ $APP_ENV == 'dev' ]; then
    grep -v "$DOCKER_IP szepul.hu.dev szepul.hu.test" /etc/hosts > temp && sudo mv temp /etc/hosts
fi

echo "Deleting vendor files..."
rm -rf application/vendor

echo "Deleting build files..."
rm -rf application/app/build

echo "Deleting fixture files..."
rm -rf application/src/Application/DataFixtures/data

echo "Done."
