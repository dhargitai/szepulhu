FROM diatigrah/php-nginx-projectbase:0.2.3

# Graphviz is a dependency of PHPDocumentor2
RUN apt-get update && apt-get install graphviz --assume-yes

# JSHint is used for syntax checking JavaScript source files
RUN npm install -g jshint

ADD docker/services/nginx/sites /etc/nginx/sites-enabled

ADD application /var/www/szepul.hu
ADD docker/run.sh /root/run.sh

ADD application/bin/wait-for-db.sh /wait-for-db.sh
RUN chmod a+x /wait-for-db.sh
RUN usermod -d /tmp/www-data www-data

WORKDIR /var/www/szepul.hu
