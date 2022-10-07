FROM php:5.5-fpm-alpine

RUN apk add --no-cache \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        coreutils \
        freetype-dev

RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/lib/ \
        --with-png-dir=/usr/lib/ \
        --with-jpeg-dir=/usr/lib/ \
        --with-gd

RUN docker-php-ext-install -j$(nproc) gd mysql mysqli