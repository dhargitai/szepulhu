FROM mysql

ADD mysqld.cnf /etc/mysql/conf.d/
ADD mysqld.sh /usr/local/bin/
ENTRYPOINT ["mysqld.sh"]