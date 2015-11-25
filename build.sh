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

docker-compose -f "$docker_compose_config" up -d --force-recreate

./application/bin/wait-for-webserver.sh "$docker_image_web"

echo; echo "Setting up permissions to the database..."
docker exec -it "$docker_image_mysql" /bin/bash -c "
    mysql -uroot -p$MYSQL_ROOT_PASSWORD << EOF
GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* To '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';
GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* To '$MYSQL_USER'@'localhost' IDENTIFIED BY '$MYSQL_PASSWORD';
DROP DATABASE IF EXISTS $MYSQL_DATABASE;
EOF
"

echo; echo "Building project dependecies..."
docker exec -i "$docker_image_web" /bin/bash < ./application/bin/configure-web-node.sh

echo
echo "Ok, done! Let's work!"
