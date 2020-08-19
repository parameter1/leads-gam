#!/bin/bash
set -e
echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_USERNAME" --password-stdin

docker build -t "leads-gam:$TRAVIS_TAG" .
docker tag "leads-gam:$TRAVIS_TAG" "limit0/leads-gam:$TRAVIS_TAG"
docker push "limit0/leads-gam:$TRAVIS_TAG"
docker image rm "leads-gam:$TRAVIS_TAG"
