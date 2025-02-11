FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY public/ .

EXPOSE 80

CMD ["apache2-foreground"]