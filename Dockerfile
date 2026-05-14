FROM php:8.2-apache

# 1. Instalamos dependencias de sistema y Node.js (necesario para Tailwind)
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Habilitamos las rutas amigables de Laravel en Apache
RUN a2enmod rewrite

# 3. Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copiamos nuestro proyecto al servidor
WORKDIR /var/www/html
COPY . .

# 5. Instalamos librerias de PHP y compilamos el CSS
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# 6. Damos permisos a las carpetas de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7. Apuntamos el servidor a la carpeta /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 8. Configuramos el puerto de Render y arrancamos
CMD sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf \
    && php artisan storage:link \
    && php artisan migrate --force \
    && apache2-foreground
