# docker/php/Dockerfile
FROM php:8.2-fpm


# Install PHP extensions & tools

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

 
#  Install Composer
 
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

 
#  Install Node.js (optional for assets)
 
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

 
#  Set working directory
 
WORKDIR /var/www/html

 
#  Create non-root user
 
# Define UID/GID
ARG UID=1000
ARG GID=1000

# Create group and user
RUN groupadd -g ${GID} appuser && useradd -u ${UID} -g ${GID} -m appuser

 
#  Copy Composer files first (cache layer)
 
COPY composer.json composer.lock* /var/www/html/

# Install PHP dependencies (no autoloader yet)
RUN composer install --no-scripts --no-autoloader --no-interaction --prefer-dist || true

 
#  Copy the rest of the application
 
COPY . /var/www/html

 
#  Run Composer properly
 
RUN composer dump-autoload --optimize && composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

 
#  Set permissions
 
RUN chown -R appuser:appuser /var/www/html/storage /var/www/html/bootstrap/cache

 
#  Switch to non-root user
 
USER appuser

 
# 1 Expose port & start PHP-FPM
 
EXPOSE 9000
CMD ["php-fpm"]
