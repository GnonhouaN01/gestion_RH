# docker/php/Dockerfile
FROM php:8.2-fpm



# Installs
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    curl \
    nano \
    gnupg2 \
    ca-certificates \
    procps \
    && docker-php-ext-install pdo_mysql zip intl mbstring bcmath sockets gd

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node (optional: useful for assets build)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Create working dir
WORKDIR /var/www/html

# Create user (optional)
RUN groupadd -g ${GID} appuser && useradd -u ${UID} -g ${GID} -m appuser

# Copy composer files separately (cache layer)
COPY composer.json composer.lock* /var/www/html/
RUN composer install --no-scripts --no-autoloader --no-interaction --prefer-dist || true

# Copy rest of the app
COPY . /var/www/html

# Run composer properly (install)
RUN composer dump-autoload --optimize && composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# Permissions
RUN chown -R appuser:appuser /var/www/html/storage /var/www/html/bootstrap/cache

# Switch to non-root user
USER appuser

EXPOSE 9000
CMD ["php-fpm"]
