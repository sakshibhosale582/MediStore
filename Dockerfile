FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install intl mysqli pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN a2enmod rewrite

RUN printf '<VirtualHost *:80>\n\
DocumentRoot /var/www/html/public\n\
<Directory /var/www/html/public>\n\
AllowOverride All\n\
Require all granted\n\
</Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/writable/cache \
    /var/www/html/writable/logs \
    /var/www/html/writable/session \
    /var/www/html/writable/uploads \
    && chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 777 /var/www/html/writable

EXPOSE 80

CMD ["apache2-foreground"]