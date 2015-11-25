#!/bin/bash
echo "Waiting for the webserver..."

until [[ "`docker exec $1 /bin/sh -c 'service nginx status'`" == *"nginx is running"* ]]; do
    printf "."
    sleep 5;
done;
echo " Got it!"
