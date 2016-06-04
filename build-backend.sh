#!/usr/bin/env bash

: '
This file is part of the szepul.hu application.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
'

display_usage() {
	cat <<EOF
Usage: $0

This is a helper script which builds the backend specific part of the application.

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
composer_home="$HOME/.composer"

if ! is_image_exists php-builder; then
    echo -n "Creating image php-builder..."
    docker build -t php-builder "$builder_dir"
fi

docker run --rm -v "$src_dir":/var/src -v "$builder_dir":/var/builder -v "$composer_home":/var/composer-home -it php-builder

docker build -t php-builder builder
docker run --rm -v "$src_dir":/var/src -v "$builder_dir":/var/builder -it php-builder