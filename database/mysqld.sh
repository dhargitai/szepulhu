#!/bin/bash

if [ ! -z $MYSQL_DATA_DIR ]; then
    mkdir -p "$MYSQL_DATA_DIR"
    sed -i "s/datadir/datadir = $MYSQL_DATA_DIR/" /etc/mysql/conf.d/mysqld.cnf
fi

./entrypoint.sh mysqld
