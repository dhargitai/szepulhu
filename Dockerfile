FROM diatigrah/php-nginx-projectbase:0.2.0

ADD docker/services/php5-fpm/php.ini /etc/php5/fpm/conf.d/40-custom.ini
ADD docker/services/php5-fpm/php.ini /etc/php5/cli/conf.d/40-custom.ini
ADD docker/services/nginx/sites /etc/nginx/sites-enabled

ADD application /var/www/szepul.hu
ADD docker/run.sh /root/run.sh

RUN echo '127.0.0.1 szepul.hu.dev' >> /etc/hosts

WORKDIR /var/www/szepul.hu

RUN composer config -g github-oauth.github.com fa748cab6ccc830d796ce74ed651807c3cd16fd2
