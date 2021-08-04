#!/usr/bin/env bash

cp .env.example .env

cd laradock || exit
cp ../.env.laradock .env
docker-compose up -d nginx
cd ..

CONTAINER_WORKSPACE_ID=$(docker ps -aqf "ancestor=automonde_workspace")

docker exec "$CONTAINER_WORKSPACE_ID" composer install;
docker exec "$CONTAINER_WORKSPACE_ID" vendor/bin/phpunit;


cd laradock || exit
docker-compose down
