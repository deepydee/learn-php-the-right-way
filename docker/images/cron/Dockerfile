FROM php:8.2.8-cli-alpine3.18

WORKDIR /var/www/html

RUN addgroup -g 1000 webserver && adduser -G webserver -g webserver -s /bin/sh -D webserver

RUN apk add --no-cache \
        bash \
        nano \
        git \
        freetype-dev \
        libpng-dev \
        libzip-dev \
        libwebp-dev \
        libjpeg-turbo-dev \
        mysql-client

RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libzip-dev \
        zlib-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
        bz2 \
        gd \
        zip \
        pdo_mysql \
        opcache && \
    pecl install --onlyreqdeps --configureoptions='enable-redis-igbinary="yes" enable-redis-lzf="yes"' \
        igbinary \
        redis && \
    docker-php-ext-enable \
        igbinary \
        redis && \
    apk del --no-network .build-deps

RUN curl -L https://raw.githubusercontent.com/johanhaleby/bash-templater/master/templater.sh -o /usr/local/bin/templater && chmod +x /usr/local/bin/templater

COPY docker/images/cron/configs/php.ini /usr/local/etc/php/conf.d/custom.ini

COPY docker/images/cron/configs/start.sh /run/start.sh
RUN chmod +x /run/start.sh

COPY --chown=webserver:webserver ./app .

# CRON
COPY docker/images/cron/configs/crontab /var/spool/cron/crontabs/root

CMD ["/run/start.sh"]
