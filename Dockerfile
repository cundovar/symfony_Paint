# Utilisez une image de PHP avec Apache
FROM php:7.4-apache

# Définissez le répertoire de travail
WORKDIR /var/www/html

# Copiez les fichiers de votre projet Symfony dans le conteneur
COPY . .

# Installez les dépendances PHP nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Exposez le port sur lequel Apache fonctionne (par défaut 80)
EXPOSE 80

# Commande pour démarrer l'application (adaptée à Symfony)
CMD ["apache2-foreground"]