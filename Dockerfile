FROM php:8.2-apache

# 1. Instalar drivers de base de datos
RUN docker-php-ext-install pdo pdo_mysql

# 2. Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# 3. Copiar los archivos al directorio correcto del servidor
COPY . /var/www/html/

# 4. Dar permisos a la carpeta
RUN chown -R www-data:www-data /var/www/html/

# 5. Configurar el puerto que Railway usa por defecto
ENV PORT 80
EXPOSE 80

# 6. Comando para iniciar Apache
CMD ["apache2-foreground"]
