FROM php:8.2-fpm-alpine3.18

RUN addgroup -g 1000 webserver && adduser -G webserver -g webserver -s /bin/sh -D webserver

COPY docker/images/php/configs/nginx.conf /etc/nginx/nginx.conf
COPY docker/images/php/configs/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/images/php/configs/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/images/php/configs/supervisord.conf /etc/supervisord.conf

RUN apk add --no-cache \
        nginx \
        mysql-client

RUN apk add --no-cache --virtual .build-deps \
        linux-headers \
        $PHPIZE_DEPS && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del --no-network .build-deps && \
    docker-php-ext-install -j$(nproc) \
        zip \
        pdo_mysql

RUN chown -R webserver.webserver /var/www/html && \
    chown -R webserver.webserver /run && \
    chown -R webserver.webserver /var/lib/nginx && \
    chown -R webserver.webserver /var/log/nginx

COPY --chown=webserver:webserver docker/images/php/configs/start.sh /run/start.sh
RUN chmod +x /run/start.sh

USER webserver

EXPOSE 80

CMD ["/run/start.sh"]
