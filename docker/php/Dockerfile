FROM php:7.4-apache

ARG UID
ARG GID
RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

RUN apt update \
        && apt install -y \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
        && docker-php-ext-install \
            intl \
            opcache \
            pdo \
            pdo_pgsql \
            pgsql

WORKDIR /var/www/laravel_docker

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN a2enmod rewrite
RUN service apache2 restart
