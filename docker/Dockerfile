# Stage 1: build Composer
FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-req=ext-mongodb

#Stage 2: build NodeJS
FROM node:20-alpine AS node
WORKDIR /app

COPY . .
RUN npm install && npm run build

#Stage 3: runtime Laravel
FROM trafex/php-nginx:latest
WORKDIR /var/www/html

USER root

RUN apk add --no-cache \
    openssl \
    php85-pecl-mongodb \
    php85-pdo \
    php85-pdo_mysql \
    php85-tokenizer \
    php85-dom \
    php85-xml \
    php85-xmlwriter \
    php85-session \
    php85-ctype \
    && cp /etc/php83/conf.d/00_mongodb.ini /etc/php83/conf.d/docker-php-ext-mongodb.ini || true

COPY --chown=nobody:nobody . .
COPY --from=composer --chown=nobody:nobody /app/vendor ./vendor
COPY --from=node --chown=nobody:nobody /app/public/build ./public/build

RUN chown -R nobody:nobody /var/www/html/storage /var/www/html/bootstrap/cache
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chown -R nobody:nobody /var/www/html/storage /var/www/html/bootstrap/cache

USER nobody
