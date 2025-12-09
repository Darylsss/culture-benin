# Version simplifiée
FROM php:8.2-cli

WORKDIR /var/www/html

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev default-mysql-client unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier l'application
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Permissions Laravel
RUN chmod -R 775 storage bootstrap/cache

# Exposer le port Railway
EXPOSE $PORT

# Commande de démarrage avec migrations
CMD bash -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"