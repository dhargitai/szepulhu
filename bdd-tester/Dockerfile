FROM alpine:latest

RUN apk add --update --repository http://dl-4.alpinelinux.org/alpine/edge/testing \
        curl php7 php7-zip php7-bz2 php7-mbstring php7-json php7-phar php7-openssl php7-curl php7-ctype php7-dom \
        php7-xdebug && \
    ln -s /usr/bin/php7 /usr/bin/php && \
    rm -rf /var/cache/apk/*

ADD config/php/xdebug.ini /etc/php7/conf.d/

RUN mkdir -p /var/test-tools \
    && mkdir -p /var/tester \
    && mkdir -p /var/tests/features

WORKDIR /var/test-tools

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ADD composer.json /var/test-tools/
RUN composer install --ansi --prefer-dist --no-interaction
ENV PATH="$PATH:/var/test-tools/bin"

VOLUME /var/tests/features
VOLUME /var/tester

WORKDIR /var/tests

CMD ["/var/tester/behat.sh"]