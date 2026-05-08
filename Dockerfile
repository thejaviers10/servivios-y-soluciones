FROM php:8.2-apache

# 1. Instalar drivers de MySQL (Lo que causaba el error original)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 2. Copiar tus archivos
COPY . /var/www/html/

# 3. Permisos
RUN chown -R www-data:www-data /var/www/html/

# 4. Configurar puerto de forma simple para Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 5. Comando de inicio limpio
CMD ["apache2-foreground"]
