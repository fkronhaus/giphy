FROM php:8.2-fpm

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql