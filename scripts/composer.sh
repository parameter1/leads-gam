#!/bin/bash
docker-compose run \
  --entrypoint /usr/bin/composer \
  --no-deps \
  -e COMPOSER_ALLOW_SUPERUSER=1 \
  app \
  $@
