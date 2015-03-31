#!/bin/bash

# dev env
rm -rf docker/mysql/*
docker-compose up -d
docker ps
echo ""
echo "The containers has been started. Please be patient as clearing the Symfony cache could take some time..."
echo "Once it's done should see the site at http://szepul.hu.dev"
