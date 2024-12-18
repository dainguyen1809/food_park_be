FROM php:8.2-fpm

# Install required dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libmagickwand-dev \
    imagemagick \
    libzip-dev \
    && docker-php-ext-install zip

# Install and enable the imagick extension
RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Install additional PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy custom php.ini configuration
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Create and set permissions for PHP log directory
RUN mkdir -p /var/log/php && \
    chmod -R 777 /var/log/php

# Set working directory
WORKDIR /var/www/html
