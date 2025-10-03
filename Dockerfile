# Dockerfile for Laravel on Render (Docker)
# Multi-stage to keep image small

# 1) Base with PHP-Apache and system deps
FROM php:8.2-apache AS app

# Install system packages and PHP extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libpq-dev \
        libzip-dev \
        zip \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer from official image to avoid installing it manually
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install deps first (better layer caching)
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy the rest of the app
COPY . .

# Use public as the DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT%/public/}!g' /etc/apache2/apache2.conf

# Ensure storage and cache are writable
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rw storage bootstrap/cache

# Add entrypoint to adjust port and run artisan setup
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose a default port for local use; on Render we will override via $PORT
EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
