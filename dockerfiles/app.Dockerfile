FROM php:8.2-fpm-alpine

RUN apk --update --no-cache add \
    php-pgsql \
    nginx \
    supervisor \
    postgresql-dev \
    && docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY . /var/www/html

USER root

RUN rm -rf /var/cache/*

RUN composer install --optimize-autoloader --no-scripts --no-interaction

COPY config/nginx.conf /etc/nginx/nginx.conf

COPY config/fpm.conf /usr/local/etc/php-fpm.conf
COPY config/php.ini /etc/php82/conf.d/php_custom.ini

COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chmod 777 -R var

EXPOSE 8000

RUN echo "include=/usr/local/etc/php-fpm.conf" | tee -a /usr/local/etc/php-fpm.d/www.conf

CMD [ "/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf" ]