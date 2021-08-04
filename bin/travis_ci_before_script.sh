#!/usr/bin/env bash

cd laradock || exit
cp ../.env.laradock .env
docker-compose up -d nginx mysql redis elasticsearch
cd ..

docker ps
CONTAINER_NAME=$(docker ps | grep 'automonde_workspace' | awk '{ print \$15 }')

docker exec $CONTAINER_NAME composer install;

cd laradock || exit
docker-compose down
