FROM php:8.3-fpm

RUN apt-get update --fix-missing && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

RUN apt-get install apt-utils unzip -y
RUN apt-get update -y
RUN apt-get upgrade -y

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap



EXPOSE 8000

CMD ["php-fpm"]
