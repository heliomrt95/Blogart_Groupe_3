FROM php:8.3-apache

RUN apt-get update && apt-get install -y libonig-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mysqli mbstring
RUN rm -f /etc/apache2/mods-enabled/mpm_*.conf /etc/apache2/mods-enabled/mpm_*.load && \
    ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf && \
        ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load && \
            a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
RUN sed -i 's/Listen 80$/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/\*:80>/\*:8080>/' /etc/apache2/sites-enabled/000-default.conf
RUN echo 'PassEnv DB_HOST DB_USER DB_PASSWORD DB_DATABASE APP_DEBUG' >> /etc/apache2/apache2.conf

COPY . /var/www/html/
RUN echo "# empty" > /var/www/html/.env

EXPOSE 8080
CMD ["apache2-foreground"]
