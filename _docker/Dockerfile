FROM php:8.4-fpm AS builder

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libpq-dev \
    libicu-dev \
    libmemcached-dev \
    librabbitmq-dev \
    git \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_pgsql \
        pgsql \
        curl \
        intl \
        pcntl \
        fileinfo \
        mbstring \
        sockets \
        zip

RUN pecl install amqp memcached xdebug \
    && docker-php-ext-enable amqp memcached xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

WORKDIR /var/www
COPY . .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

USER www-data

RUN composer install --no-cache --no-dev --optimize-autoloader \
    && npm install --production --no-package-lock \
    && rm -rf ~/.composer/cache/ ~/.npm/

USER root
RUN rm -rf /tmp/*

EXPOSE 9000
CMD ["php-fpm"]
