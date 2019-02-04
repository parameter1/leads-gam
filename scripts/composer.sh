#!/bin/bash
docker-compose run \
  --entrypoint /var/www/html/composer.phar \
  --no-deps \
  app
  $@
