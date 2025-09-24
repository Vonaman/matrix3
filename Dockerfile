# Utiliser PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les extensions nécessaires pour Symfony
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip

# Activer mod_rewrite (obligatoire pour Symfony routes)
RUN a2enmod rewrite

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tout ton projet dans le conteneur
COPY . .

# Installer les dépendances Symfony en prod
RUN composer install --no-dev --optimize-autoloader

# Donner les bons droits à var/ (cache & logs Symfony)
RUN chown -R www-data:www-data var

# Exposer le port 80 (HTTP)
EXPOSE 80

# Dossier public comme racine web
WORKDIR /var/www/html/public
