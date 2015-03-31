#!/bin/bash

docker build -t szepulhu_front .
docker run -d --name db -P mysql
docker run -d --link db:DB_1 -P szepulhu_front
