#!/usr/bin/env bash

: '
This file is part of the szepul.hu application.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
'

display_usage() {
	cat <<EOF
Usage: $0

This a helper script which builds the backend specific part of the application.

-h      Display help.
EOF
}

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
builder_dir="$cwd/builder"

docker run --rm -v "$src_dir":/var/src -v "$builder_dir":/var/builder -it php-builder
