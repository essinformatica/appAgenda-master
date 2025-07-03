# Estágio 1: Instalar dependências do Composer
FROM composer:1.10 as vendor

WORKDIR /app
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist

# Estágio 2: Instalar dependências do NPM e compilar assets
FROM node:14 as frontend

WORKDIR /app
COPY package.json package.json
RUN npm install
COPY . .
RUN npm run production

# Estágio 3: Imagem final da aplicação com PHP-FPM
FROM php:7.4-fpm

WORKDIR /var/www

# Instalar extensões PHP necessárias para o Laravel
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Copiar arquivos da aplicação e dependências
COPY . .
COPY --from=vendor /app/vendor/ ./vendor/
COPY --from=frontend /app/public/js/ ./public/js/
COPY --from=frontend /app/public/css/ ./public/css/
COPY --from=frontend /app/mix-manifest.json ./mix-manifest.json

# Definir permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
