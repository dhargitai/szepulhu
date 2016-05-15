#!/bin/bash

./build-backend.sh && \
./build-frontend.sh && \
docker-compose build --pull
docker-compose up -d && ./application/bin/wait-for-webserver.sh && ./build-bdd-tests.sh