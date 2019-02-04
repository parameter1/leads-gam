FROM php:7.3.1-apache

RUN apt-get update -qq \
  && apt-get install -qq --no-install-recommends \
    git \
    zip \
    unzip \
    zlib1g-dev \
  && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT /app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
  && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
  && a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
