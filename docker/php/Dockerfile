FROM php:8.2-fpm-alpine

# Install system dependencies and PostgreSQL drivers
RUN apk add --no-cache libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
