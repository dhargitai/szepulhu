#!/usr/bin/env bash

: '
This file is part of the szepul.hu application.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
'

display_usage() {
	cat <<EOF
Usage: $0

This is a helper script which runs Behat tests of the application.

-h      Display help.
-b      Hand over arguments to Behat.
-c      Clean up: kill running PhantomJS container and remove the container.
-x      Enable Xdebug PHP extension during tests execution. Default is disabled.
EOF
}

source build-functions.sh

while getopts ":hb:cx" opt; do
  case $opt in
    h)
      display_usage
      exit 0;
      ;;
    b)
      BEHAT_ARGUMENTS="/var/tester/behat.sh $OPTARG"
      ;;
    c)
      if is_container_running phantomjs; then
        echo -n "Stopping container phantomjs..."
        docker stop phantomjs > /dev/null
        echo "done."
      fi
      if is_container_exists phantomjs; then
        echo -n "Removing container phantomjs..."
        docker rm phantomjs > /dev/null
        echo "done."
      fi
      exit 0;
      ;;
    x)
      XDEBUG_ENABLED=1
      ;;
    \?)
      echo "Invalid option: -$OPTARG" >&2
      exit 1;
      ;;
  esac
done

cwd=$(pwd)
source "$cwd/.env"
features_dir="$cwd/application/features"
behat_config_file="$cwd/application/behat.yml"
behat_script="$cwd/bdd-tester-for-osx/behat.sh"
behat_element_finder_extension="$cwd/application/src/Geza"
test_container_ip=$(docker inspect --format '{{ .NetworkSettings.IPAddress }}' szepulhu_web_2)

if ! is_image_exists bdd-tester; then
    echo -n "Creating image bdd-tester for OSX..."
    docker build -t bdd-tester:osx bdd-tester-for-osx
fi

docker run --rm -v "$features_dir":/var/tests/features \
    -v "$behat_element_finder_extension":/var/tests/extensions/Geza \
    -v "$behat_config_file":/var/tests/behat.yml \
    -v "$behat_script":/var/tester/behat.sh \
    -e "APP_XDEBUG=$XDEBUG_ENABLED" \
    -e "DOCKER_IP=$DOCKER_IP" \
    --add-host test.szepul.hu.dev:$test_container_ip \
    --add-host phantomjs.dev:127.0.0.1 \
    -it bdd-tester:osx ${BEHAT_ARGUMENTS}
