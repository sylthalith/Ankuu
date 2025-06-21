FROM php:8.4-fpm

RUN apt-get update && apt-get install -y git

RUN git config --global user.email "sylthalith@gmail.com"
RUN git config --global user.name "sylthalith"

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get install -y curl
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install -y nodejs
RUN rm nodesource_setup.sh

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

RUN git config --global --add safe.directory /var/www/html
