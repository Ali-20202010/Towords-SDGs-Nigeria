# Use PHP 8.2 with Apache
FROM php:8.2-apache

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev zip \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql gd mbstring exif pcntl bcmath opcache

# Enable Apache rewrite (needed for pretty URLs)
RUN a2enmod rewrite

# Point Apache to Laravel's /public
# 1) Change DocumentRoot
RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# 2) Ensure .htaccess is honored and directory is accessible
RUN printf "%s\n" \
  "<Directory /var/www/html/public>" \
  "    AllowOverride All" \
  "    Require all granted" \
  "</Directory>" > /etc/apache2/conf-available/laravel.conf \
  && a2enconf laravel

# Workdir
WORKDIR /var/www/html

# Copy code
COPY . /var/www/html

# Install Composer (from official image)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Permissions for storage/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 80 (Apache default)
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
