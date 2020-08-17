FROM php:7.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache autoconf g++ make shadow

RUN usermod -u 1000 www-data

RUN groupmod -g 1000 www-data

RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-source extract

RUN pecl install xdebug redis

RUN docker-php-ext-enable redis xdebug
