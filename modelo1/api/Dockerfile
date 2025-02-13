FROM php:8.2-apache

RUN mkdir /var/www/src

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/src

COPY src/ .

WORKDIR /var/www/html

COPY public/ .

RUN composer require firebase/php-jwt

EXPOSE 80

CMD ["apache2-foreground"]