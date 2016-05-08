#!/bin/bash

./build-backend.sh && \
./build-frontend.sh && \
docker-compose build --pull
docker-compose start && ./build-bdd-tests.sh