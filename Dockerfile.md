# Use official PHP image with Apache
FROM php:8.1-apache

# Enable PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files into container
COPY . /var/www/html/

# Expose port 80
EXPOSE 80
