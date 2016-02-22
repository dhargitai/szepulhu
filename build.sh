#!/bin/bash

./build-backend.sh && \
./build-frontend.sh && \
docker-compose build --pull
# && ./run-integration-tests.sh