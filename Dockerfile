# Dockerfile
FROM php:8.2-apache

# Mettre à jour et installer les dépendances
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Activer les modules Apache nécessaires
RUN a2enmod rewrite headers

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de configuration
COPY . .

# Installer les dépendances Composer (PRODUCTION)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Configurer les permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Créer le fichier de configuration Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf



# Utiliser le port dynamique de Railway
EXPOSE $PORT
CMD sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf && \
    sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/*.conf && \
    apache2-foreground