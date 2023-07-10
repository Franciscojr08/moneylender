FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    && apt-get install -y zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli \
    && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN cd /etc/apache2/mods-available/ && a2enmod rewrite
EXPOSE 80
