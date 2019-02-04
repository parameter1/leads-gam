#!/bin/bash
docker-compose run \
  --entrypoint /usr/bin/composer \
  --no-deps \
  app \
  $@
