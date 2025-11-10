# 1. Use an official PHP image with Apache
FROM php:8.2-apache

# 2. Set up the working directory
WORKDIR /var/www/html

# 3. Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring exif pcntl bcmath opcache pdo pdo_mysql xml

# 4. Install Composer (the PHP package manager)
COPY --from=composer/latest /usr/bin/composer /usr/bin/composer

# 5. Copy your local files into the container
COPY . .

# 6. Install your project's dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# 7. Set correct permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Expose the port Apache runs on
EXPOSE 80