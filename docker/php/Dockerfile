FROM php:8.2-fpm

RUN apt-get update && apt-get install \
    && apt-get install -y libzip-dev npm \
    && npm install -g yarn \
    && apt-get clean \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) bcmath \
    && docker-php-ext-install -j$(nproc) zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
