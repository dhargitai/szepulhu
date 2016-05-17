#!/usr/bin/env bash

: '
This file is part of the szepul.hu application.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
'

display_usage() {
	cat <<EOF
Usage: $0

This is a helper script which sets up the development specific part of the application.

-h      Display help.
EOF
}

source build-functions.sh

is_watch_mode=0
while getopts ":h" opt; do
  case $opt in
    h)
      display_usage
      exit 0;
      ;;
    \?)
      echo "Invalid option: -$OPTARG" >&2
      exit 1;
      ;;
  esac
done


cwd=$(pwd)
src_dir="$cwd/application"
builder_dir="$cwd/php-builder"

docker run --rm -v "$src_dir":/var/src -v "$builder_dir":/var/builder -it php-builder bash -c "./bin/phing -f /var/builder/build.xml dev"

if ! is_image_exists szepulhu_mysql_with_fixtures; then
    echo -n "Creating database image with fixtures..."
    docker-compose up -d && ./application/bin/wait-for-webserver.sh
    docker exec -it szepulhu_web_1 /bin/bash -c "./bin/install-fixtures.sh"
    docker commit szepulhu_mysql szepulhu_mysql_with_fixtures
    docker-compose stop
fi

docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d --force-recreate && ./application/bin/wait-for-webserver.sh