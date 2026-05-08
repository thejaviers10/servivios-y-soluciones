FROM php:8.2-apache

# Instalamos los drivers de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiamos tus archivos
COPY . /var/www/html/

# Permisos necesarios
RUN chown -R www-data:www-data /var/www/html/

# NO añadiremos comandos de puerto ni de inicio. 
# Dejaremos que Railway use su configuración por defecto para evitar choques.
