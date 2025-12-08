FROM php:8.2-cli

WORKDIR /var/www/html

# Copier d'abord composer.json pour le cache
COPY composer.json composer.lock ./

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier tout le reste
COPY . .

# Exécuter les scripts post-installation
RUN composer run-script post-install-cmd

# Configurer les permissions
RUN chmod -R 755 storage bootstrap/cache

# Exposer le port (Railway définit $PORT automatiquement)
EXPOSE $PORT

# Démarrer le serveur PHP intégré
CMD php artisan serve --host=0.0.0.0 --port=$PORT