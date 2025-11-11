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
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring exif pcntl bcmath opcache pdo pdo_pgsql xml

# 4. Copy our new Apache config file
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# 5. Enable Apache's rewrite module
RUN a2enmod rewrite

# 6. Install Composer (the PHP package manager)
COPY --from=composer/latest /usr/bin/composer /usr/bin/composer

# 7. Copy your local files into the container
COPY . .

# 8. Install your project's dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# 9. Set correct permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Expose the port Apache runs on
EXPOSE 80