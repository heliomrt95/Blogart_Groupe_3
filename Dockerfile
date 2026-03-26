FROM php:8.3-apache

RUN apt-get update && apt-get install -y libonig-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mysqli mbstring
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
RUN sed -i 's/Listen 80$/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/\*:80>/\*:8080>/' /etc/apache2/sites-enabled/000-default.conf

COPY . /var/www/html/

EXPOSE 8080
CMD ["apache2-foreground"]
