FROM php:8.2-apache


# Define o diretório de trabalho
WORKDIR /var/www/html

# Dependências e extensões PHP
RUN apt-get update && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        zip \
        unzip \
        libxml2-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        xml \
        zip \
        sockets \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Copia a pasta do projeto para o container
COPY laravel/ .

# Instala as dependências do Composer
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# Gera o autoload otimizado do Composer
RUN composer dump-autoload --optimize

# Resolvendo possíveis problemas de permissões
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache