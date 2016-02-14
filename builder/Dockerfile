FROM diatigrah/php-base:1.0.0.5.6

RUN apk --update --no-progress add bash git
RUN rm -rf /var/cache/apk/*

RUN mkdir -p /var/src
RUN mkdir -p /var/build-tools
RUN mkdir -p /var/builder
RUN mkdir -p /var/build

WORKDIR /var/build-tools

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

VOLUME /var/src
VOLUME /var/builder
VOLUME /var/build/logs

ADD composer.json /var/build-tools/
RUN composer install --ansi --prefer-dist --no-interaction

CMD ["/var/builder/build.sh"]