FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql mysqli mbstring
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

RUN printf '#!/bin/bash\nset -e\nPORT="${PORT:-80}"\nsed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf\nsed -i "s/*:80>/*:$PORT>/" /etc/apache2/sites-enabled/000-default.conf\nexec apache2-foreground\n' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]
