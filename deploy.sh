#!/bin/bash
set -e

IMAGE="limit0/leads-gam:${TRAVIS_TAG}"

echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_USERNAME" --password-stdin
docker build -t "leads-gam:${TRAVIS_TAG}" .
docker tag "leads-gam:${TRAVIS_TAG}" $IMAGE
docker push $IMAGE

# Deploy the image
yarn global add @base-cms/travis-rancher-deployer
deploy-to-rancher $IMAGE $SERVICE_TARGET
