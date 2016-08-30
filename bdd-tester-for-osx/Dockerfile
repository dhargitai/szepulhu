FROM phusion/baseimage:0.9.19

RUN apt-get update && apt-get install -y software-properties-common ca-certificates bzip2 libfontconfig php php-zip php-bz2 php-mbstring php-json php-phar php-curl php-ctype php-dom php-xdebug php-curl

# Clean up APT when done.
RUN apt-get --purge autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ADD config/php/xdebug.ini /etc/php7/conf.d/

RUN mkdir -p /var/test-tools \
    && mkdir -p /var/tester \
    && mkdir -p /var/tests/features

WORKDIR /var/test-tools

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ADD composer.json /var/test-tools/
RUN composer install --ansi --prefer-dist --no-interaction
ENV PATH="$PATH:/var/test-tools/bin"

RUN mkdir /tmp/phantomjs && \
    curl -L https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2 \
    | tar -xj --strip-components=1 -C /tmp/phantomjs && \
    mv /tmp/phantomjs/bin/phantomjs /usr/local/bin
RUN useradd --system --uid 72379 -m --shell /usr/sbin/nologin phantomjs

ADD services/phantomjs /etc/service/phantomjs

VOLUME /var/tests/features
VOLUME /var/tester

WORKDIR /var/tests

CMD ["/var/tester/behat.sh"]