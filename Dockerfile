FROM php:8.2-apache

# 1. Instalar drivers de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 2. Habilitar el módulo de reescritura (por si acaso)
RUN a2enmod rewrite

# 3. Copiar tus archivos
COPY . /var/www/html/

# 4. Dar permisos
RUN chown -R www-data:www-data /var/www/html/

# 5. Obligar a Apache a escuchar en el puerto que Railway quiere
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 6. Comando para iniciar
CMD ["apache2-foreground"]
