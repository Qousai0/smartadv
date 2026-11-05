
FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev \
    libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan package:discover --ansi

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
