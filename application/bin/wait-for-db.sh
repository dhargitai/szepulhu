#!/bin/sh
echo "Waiting for database connection..."
while ! curl -s http://$DB_1_PORT_3306_TCP_ADDR:$DB_1_PORT_3306_TCP_PORT/ > /dev/null
do
  echo -n "."
  sleep 1
done
echo " Got it!"
