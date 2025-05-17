# Official PHP image with Apache
FROM php:8.0-apache

# Set the working directory to the web server's document root
WORKDIR /var/www/html

# Copy the application files to the web server directory
COPY public /var/www/html/public
COPY app /var/www/html/app
COPY src /var/www/html/src
COPY uploads /var/www/html/uploads
COPY index.php /var/www/html/index.php


# Set correct permissions for the uploads directory
RUN chmod -R 755 /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html/uploads


# Expose port 80 for HTTP traffic
EXPOSE 80