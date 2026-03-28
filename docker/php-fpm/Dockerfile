FROM php:8.5-rc-fpm-alpine3.22

RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    icu-dev \
    && docker-php-ext-install \
    pdo_mysql \
    bcmath \
    gd \
    zip \
    intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www