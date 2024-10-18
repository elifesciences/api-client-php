ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-cli

RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /code

COPY composer.json composer.json
RUN composer install

COPY . .
