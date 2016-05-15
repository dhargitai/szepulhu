FROM diatigrah/php-base:1.0.0.5.6

RUN apk --update --no-progress add bash git
RUN rm -rf /var/cache/apk/*

RUN mkdir -p /var/src
RUN mkdir -p /var/build-tools
RUN mkdir -p /var/builder
RUN mkdir -p /var/build
RUN mkdir -p /var/composer-home

WORKDIR /var/build-tools

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

VOLUME /var/src
VOLUME /var/builder
VOLUME /var/build/logs
VOLUME /var/composer-home

# Make Composer utilize the cache by mounting the Composer-Home directory from the host machine
ENV COMPOSER_HOME=/var/composer-home

ADD composer.json /var/build-tools/
RUN composer install --ansi --prefer-dist --no-interaction

CMD ["/var/builder/build.sh"]