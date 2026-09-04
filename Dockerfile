# Build PHP dependencies
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN composer dump-autoload --optimize


# Build frontend assets
FROM node:24-alpine AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# Production image
FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    nginx \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    icu-dev \
    libzip-dev \
    postgresql-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    xml \
    intl \
    bcmath \
    opcache

COPY --from=composer /app /var/www/html

COPY --from=frontend /app/public/build /var/www/html/public/build

RUN mkdir -p \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/bootstrap/cache

RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 10000

CMD ["sh", "-c", "php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'"]