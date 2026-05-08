FROM php:8.2-apache

# 1. Instalar drivers de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 2. Copiar tus archivos al servidor
COPY . /var/www/html/

# 3. Dar permisos de escritura
RUN chown -R www-data:www-data /var/www/html/

# 4. Ajuste de puerto para Railway (Simple)
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g' /etc/apache2/sites-available/000-default.conf

# 5. Iniciar Apache
CMD ["apache2-foreground"]
