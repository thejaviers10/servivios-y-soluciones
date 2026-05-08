FROM php:8.2-apache

# Instalamos el driver de MySQL para que PHP pueda conectar
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiamos tus archivos al servidor
COPY . /var/www/html/

# Ajustamos permisos de escritura
RUN chown -R www-data:www-data /var/www/html/

# Exponemos el puerto web
EXPOSE 80
