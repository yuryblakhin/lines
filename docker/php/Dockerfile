FROM php:8.2-fpm-alpine

WORKDIR "/application"

RUN apk update && apk upgrade
RUN apk add --no-cache libzip-dev zip icu-dev libpq-dev ffmpeg libwebp-dev libjpeg-turbo-dev libpng-dev libxpm-dev freetype-dev linux-headers nodejs npm
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install zip exif mysqli pdo pdo_mysql

RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-xpm --with-freetype && docker-php-ext-install gd
RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl

COPY --chown=www-data:www-data . .
COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/php-ini-overrides.ini

EXPOSE 80 443 9000
CMD ["php-fpm"]
