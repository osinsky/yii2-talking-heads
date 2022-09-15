FROM php:8.0-fpm

# RUN apk add icu-dev autoconf gcc
RUN apt-get update
RUN apt-get -y install libicu-dev zip
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo_mysql
RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini
