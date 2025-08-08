FROM php:8.4-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    gnupg \
    ca-certificates \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

ARG WWWUSER=1000
ARG WWWGROUP=1000

RUN groupmod -o -g ${WWWGROUP} www-data && \
    usermod -o -u ${WWWUSER} -g www-data www-data && \
    chown -R www-data:www-data /var/www/html

USER www-data
