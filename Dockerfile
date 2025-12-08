FROM php:8.2-apache

# Installer les extensions PHP
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip

# Activer Apache rewrite
RUN a2enmod rewrite

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier les fichiers
COPY . .

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# Configurer les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 storage bootstrap/cache

# CRITIQUE : Configurer Apache pour Railway
# 1. Créer un script de démarrage
RUN echo '#!/bin/bash\n\
\n\
# Récupérer le port de Railway\n\
if [ -z "$PORT" ]; then\n\
  PORT=8080\n\
fi\n\
\n\
# Configurer Apache pour ce port\n\
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf\n\
sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf\n\
\n\
# Démarrer Apache\n\
exec apache2-foreground' > /start.sh

RUN chmod +x /start.sh

# Exposer le port (Railway définit $PORT)
EXPOSE $PORT

# Utiliser le script de démarrage
CMD ["/start.sh"]