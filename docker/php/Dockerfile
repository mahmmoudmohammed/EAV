FROM php:8.3-fpm
WORKDIR /var/www/html

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

RUN useradd -G www-data,root -u 1000 -d /home/laravel laravel
RUN mkdir -p /home/laravel/.composer && \
    chown -R laravel:laravel /home/laravel

RUN chown -R laravel:laravel /var/www/html

USER laravel

COPY --chown=laravel:laravel . .
RUN composer install

EXPOSE 8000

CMD ["php-fpm"]
