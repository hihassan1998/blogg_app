FROM php:8.0-apache

# Install MySQL server and PHP MySQL extension
RUN apt-get update && apt-get install -y default-mysql-server default-mysql-client mariadb-client && \
    docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your app files
WORKDIR /var/www/html
COPY public /var/www/html/public
COPY app /var/www/html/app
COPY src /var/www/html/src
COPY uploads /var/www/html/uploads
COPY index.php /var/www/html/index.php

# Copy SQL file to a location
COPY sql/d0019e_blog.sql /tmp/d0019e_blog.sql

# Permissions
RUN chmod -R 755 /var/www/html/uploads && chown -R www-data:www-data /var/www/html/uploads

# Expose port 80 for Apache
EXPOSE 80

# Init script to start mysql, recreate DB, import SQL, then start Apache
CMD service mysql start && \
    sleep 10 && \
    mysql -u root -e "DROP DATABASE IF EXISTS d0019e_blog; CREATE DATABASE d0019e_blog; CREATE USER IF NOT EXISTS 'dbadm'@'localhost' IDENTIFIED BY 'P@ssw0rd'; GRANT ALL PRIVILEGES ON d0019e_blog.* TO 'dbadm'@'localhost'; FLUSH PRIVILEGES;" && \
    mysql -u dbadm -pP@ssw0rd d0019e_blog < /tmp/d0019e_blog.sql && \
    apache2-foreground
