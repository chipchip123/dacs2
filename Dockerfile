FROM php:8.2-apache

# Cài thư viện cần cho Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Bật rewrite cho Laravel
RUN a2enmod rewrite

# Thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ source code
COPY . .

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cài dependency PHP
RUN composer install --no-dev --optimize-autoloader

# Phân quyền
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Apache trỏ vào thư mục public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 10000

CMD ["apache2-foreground"]
