FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y libmariadb-dev && \
    docker-php-ext-install pdo_mysql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
