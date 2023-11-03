FROM registry.dev-mage3.com/luis-plus/backend:base

ARG NEW_RELIC_ENABELED=0
ARG NEW_RELIC_AGENT_VERSION
ARG NEW_RELIC_LICENSE_KEY
ARG NEW_RELIC_APPNAME=luis

RUN apk add --no-cache \
        nginx \
        supervisor

# Add Yandex CA
RUN wget "https://storage.yandexcloud.net/cloud-certs/CA.pem" --output-document /usr/local/share/ca-certificates/root.crt && \
    chmod 0644 /usr/local/share/ca-certificates/root.crt && \
    update-ca-certificates

# NewRelic PHP Agent
RUN if [ "$NEW_RELIC_ENABELED" = "1" ]  ; then \
        curl -L https://download.newrelic.com/php_agent/archive/${NEW_RELIC_AGENT_VERSION}/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux.tar.gz | tar -C /tmp -zx \
        && export NR_INSTALL_USE_CP_NOT_LN=1 \
        && export NR_INSTALL_SILENT=1 \
        && /tmp/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux/newrelic-install install \
        && rm -rf /tmp/newrelic-php5-* /tmp/nrinstall* ; \
    fi

RUN if [ "$NEW_RELIC_ENABELED" = "1" ]  ; then \
        sed -i -e "s/REPLACE_WITH_REAL_KEY/${NEW_RELIC_LICENSE_KEY}/" \
        -e "s/newrelic.appname[[:space:]]=[[:space:]].*/newrelic.appname=\"${NEW_RELIC_APPNAME}\"/" \
        -e '$anewrelic.daemon.address="newrelic-php-daemon:31339"' \
        $(php -r "echo(PHP_CONFIG_FILE_SCAN_DIR);")/newrelic.ini ; \
    fi

COPY docker/images/php/configs/nginx.conf /etc/nginx/nginx.conf
COPY docker/images/php/configs/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/images/php/configs/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/images/php/configs/supervisord.conf /etc/supervisord.conf
COPY docker/images/php/configs/worker.conf /etc/worker.conf

RUN chown -R webserver.webserver /var/www/html && \
    chown -R webserver.webserver /run && \
    chown -R webserver.webserver /var/lib/nginx && \
    chown -R webserver.webserver /var/log/nginx

COPY --chown=webserver:webserver docker/images/php/configs/start.sh /run/start.sh
RUN chmod +x /run/start.sh

COPY --chown=webserver:webserver ./app .

USER webserver

RUN composer install --optimize-autoloader --no-dev --no-progress --no-interaction

EXPOSE 80

CMD ["/run/start.sh"]

# HEALTHCHECK --timeout=10s --start-period=5s CMD curl --silent --fail http://127.0.0.1:80/fpm-ping
