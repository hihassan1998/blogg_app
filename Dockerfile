# Official PHP image with Apache
FROM php:8.0-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    default-mysql-server \
    default-mysql-client \
    mariadb-client \
    && docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Set the working directory to the web server's document root
WORKDIR /var/www/html

# Copy the application files to the web server directory
COPY public /var/www/html/public
COPY app /var/www/html/app
COPY src /var/www/html/src
COPY uploads /var/www/html/uploads
COPY index.php /var/www/html/index.php
# Copy SQL file
COPY sql/d0019e_blog.sql /docker-entrypoint-initdb.d/d0019e_blog.sql


# Set correct permissions for the uploads directory
RUN chmod -R 755 /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html/uploads


# Expose port 80 for HTTP traffic
EXPOSE 80

# Start MySQL and Apache
CMD service mysql start && \
    sleep 5 && \
    mysql -u root -e "CREATE USER IF NOT EXISTS 'dbadm'@'localhost' IDENTIFIED BY 'P@ssw0rd'; \
                      CREATE DATABASE IF NOT EXISTS d0019e_blog; \
                      GRANT ALL PRIVILEGES ON d0019e_blog.* TO 'dbadm'@'localhost'; \
                      FLUSH PRIVILEGES;" && \
    mysql -u dbadm -pP@ssw0rd d0019e_blog < /docker-entrypoint-initdb.d/d0019e_blog.sql && \
    apache2-foreground