#!/usr/bin/env bash

: '
This file is part of the szepul.hu application.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
'

display_usage() {
	cat <<EOF
Usage: $0

This a helper script which builds the frontend specific part of the application.

-h      Display help.
-w      Watch for file changes and build files on change.
EOF
}

is_watch_mode=0
while getopts ":wh" opt; do
  case $opt in
    w)
      echo "Building files on demand..." >&2
      is_watch_mode=1
      ;;
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
src_dir="$cwd/application/app/Resources/public"
compiler_dir="$cwd/js-compiler"
target_dir="$cwd/application/web"
environment=""

if [ "$is_watch_mode" -eq 1 ]; then
    environment="-e GULP_TASK=watch"
fi

docker build -t js-compiler js-compiler
docker run --rm -v "$src_dir":/var/src -v "$compiler_dir":/var/compiler -v "$target_dir":/var/target $environment -it js-compiler
