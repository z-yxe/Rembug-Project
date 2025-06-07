# Base image PHP + Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    pkg-config \
    libssl-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    zlib1g-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install MongoDB extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set Apache to serve Laravel from public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Copy app source code
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy dummy .env for build-time (make sure .env.example exists)
COPY .env.example .env

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel Artisan setup
RUN php artisan key:generate \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80
