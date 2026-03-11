# -----------------------------------------------------
# Stage 1 — Base PHP-FPM + extensões (Alpine)
# -----------------------------------------------------
FROM php:8.4-fpm-alpine AS php-base

# Instala dependências do sistema e extensões do PHP
RUN apk add --no-cache \
    git \
    curl \
    unzip \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html


# -----------------------------------------------------
# Stage 2 — Dependências PHP (vendor)
# -----------------------------------------------------
FROM php-base AS php-deps

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader
#RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# -----------------------------------------------------
#  Stage 3 — Build dos assets com Node (Vite)
# -----------------------------------------------------
FROM node:24-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install && npm update

COPY . .

RUN npm run build


# -----------------------------------------------------
#  Stage 4 — Aplicação Laravel final (leve)
# -----------------------------------------------------
FROM php-base AS php-prod

WORKDIR /var/www/

# Copia o código fonte
COPY . .

# Copia vendor do estágio php-deps
COPY --from=php-deps /var/www/html/vendor ./vendor

# Copia build do Vite
COPY --from=frontend /app/public/build ./public/build

# Ajusta permissões
RUN rm -r node_modules && composer install && chown -R www-data:www-data /var/www

# Porta padrão do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
