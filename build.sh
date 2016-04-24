#!/bin/bash

./build-backend.sh && \
./build-frontend.sh && \
docker-compose build --pull
docker-compose up && ./build-bdd-tests.sh