FROM php:8.2-cli

WORKDIR /var/www/html

# Copier d'abord composer.json pour optimiser le cache
COPY composer.json composer.lock ./

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP (SANS post-install-cmd)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier tout le reste du code
COPY . .

# Configurer les permissions Laravel
RUN chmod -R 775 storage bootstrap/cache

# Exposer le port (Railway définit $PORT automatiquement)
EXPOSE $PORT

# Démarrer le serveur PHP intégré
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}

# AJOUTER l'extension MySQL (pdo_mysql au lieu de pdo_pgsql)
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev default-mysql-client unzip git \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 775 storage bootstrap/cache

EXPOSE $PORT

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}