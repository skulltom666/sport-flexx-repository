# Usa una imagen base de PHP con Apache
FROM php:8.2-apache

# Copia tu código al contenedor
COPY ./src/ /var/www/html/

# Habilita extensiones de PHP que normalmente usa MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilita rewrite (útil si usas .htaccess)
RUN a2enmod rewrite
