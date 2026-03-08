# ============================================================
# Dockerfile — WordPress + Apache for Coolify
# ============================================================
FROM wordpress:php8.2-apache

# Install additional PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite (required for WordPress permalinks)
RUN a2enmod rewrite

# Copy all WordPress project files into the container
COPY . /var/www/html/

# Use the production wp-config (reads env vars from Coolify)
RUN cp /var/www/html/wp-config-production.php /var/www/html/wp-config.php

# Set correct ownership for Apache
RUN chown -R www-data:www-data /var/www/html/ \
    && find /var/www/html/ -type d -exec chmod 755 {} \; \
    && find /var/www/html/ -type f -exec chmod 644 {} \;

# Ensure uploads directory exists and is writable
RUN mkdir -p /var/www/html/wp-content/uploads \
    && chown -R www-data:www-data /var/www/html/wp-content/uploads \
    && chmod -R 775 /var/www/html/wp-content/uploads

EXPOSE 80
