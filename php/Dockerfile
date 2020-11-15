FROM php:7.4-fpm
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
EXPOSE 80
