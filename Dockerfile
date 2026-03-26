FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y libonig-dev && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (pdo is already built-in)
RUN docker-php-ext-install pdo_mysql mysqli mbstring

# Force-remove mpm_event to avoid "More than one MPM loaded" error
RUN rm -f /etc/apache2/mods-enabled/mpm_event.conf /etc/apache2/mods-enabled/mpm_event.load || true

# Enable mpm_prefork (required for mod_php) and mod_rewrite
RUN a2enmod mpm_prefork rewrite

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Pass Railway environment variables to PHP via Apache
RUN echo 'PassEnv DB_HOST DB_USER DB_PASSWORD DB_DATABASE APP_DEBUG' >> /etc/apache2/apache2.conf

# Hardcode port 8080 at build time (Railway routes to EXPOSE 8080)
RUN sed -i 's/Listen 80$/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/\*:80>/\*:8080>/' /etc/apache2/sites-enabled/000-default.conf

# Copy project files
COPY . /var/www/html/

# Empty .env so DotEnv doesn't override Railway env vars
RUN echo "# empty" > /var/www/html/.env

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Runtime MPM fix: Railway injects extra MPM modules at container startup
RUN printf '#!/bin/bash\nset -e\na2dismod mpm_event mpm_worker 2>/dev/null || true\nrm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* 2>/dev/null || true\na2enmod mpm_prefork 2>/dev/null || true\nexec apache2-foreground\n' > /start.sh && chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
