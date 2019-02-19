FROM limit0/php7:latest

ADD . /app
WORKDIR /app

RUN composer \
    install \
    --no-interaction \
    --no-dev \
    --optimize-autoloader \
    --no-plugins \
    --no-scripts \
    --prefer-dist
