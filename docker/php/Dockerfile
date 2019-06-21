FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug-conf.ini

WORKDIR /app
RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip unzip
RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

CMD composer install && sh ./init && php-fpm
