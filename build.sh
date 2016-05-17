#!/bin/bash

./build-backend.sh && \
./build-frontend.sh && \
docker-compose build --pull
./build-dev.sh && ./build-bdd-tests.sh