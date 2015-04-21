FROM diatigrah/php-nginx-projectbase

ADD docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD docker/php.ini /etc/php5/fpm/conf.d/40-custom.ini
ADD docker/sites /etc/nginx/sites-enabled

ADD application /var/www/szepul.hu
ADD docker/run.sh /root/run.sh

WORKDIR /var/www/szepul.hu

RUN composer config -g github-oauth.github.com fa748cab6ccc830d796ce74ed651807c3cd16fd2
