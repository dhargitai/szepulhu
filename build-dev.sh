#!/bin/bash

mkdir -p docker/mysql && \
docker-compose run --rm front /bin/bash -c 'bin/wait-for-db.sh && \
                                            composer install --prefer-dist && \
                                            php app/console doctrine:schema:create && \
                                            wget https://www.dropbox.com/s/ty3soyfivprjcp4/szepul.hu.fixtures.files.tar.gz?dl=0 -O /tmp/fixtures.tar.gz && \
                                            tar -xzf /tmp/fixtures.tar.gz --no-same-owner -C src/Application/DataFixtures/ && \
                                            php app/console doctrine:fixtures:load --no-interaction && \
                                            cd app/Resources/public && bower --config.interactive=false --allow-root install && cd ../../.. && \
                                            php app/console assetic:dump' && \
./start.sh
