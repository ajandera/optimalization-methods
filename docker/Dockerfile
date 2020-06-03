FROM php:7.0-apache

MAINTAINER shopyCRM <jandera@shopycrm.com>

# Install libraries
RUN apt-get update && \
    apt-get install -y \
    libzip-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev cron git

RUN docker-php-ext-install pdo_mysql bcmath zip

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd

COPY ./php.ini /usr/local/etc/php/

ADD ./apache.conf /etc/apache2/sites-available/
RUN ln -s /etc/apache2/sites-available/apache.conf /etc/apache2/sites-enabled/
RUN rm -rf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite