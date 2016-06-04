#!/bin/bash

echo -n "Waiting for the webserver..."

while ! curl -s http://szepul.hu.dev/ > /dev/null
do
  echo -n "."
  sleep 1
done

echo " Got it!"
