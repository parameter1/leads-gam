#!/bin/bash
docker-compose run \
  --entrypoint php \
  --no-deps \
  app \
  /var/www/html/composer.phar $@
