#!/usr/bin/env bash

cd laradock || exit
cp ../.env.laradock .env
docker-compose up -d nginx mysql redis elasticsearch
cd ..

docker ps

docker exec -it automonde_workspace_1_15c0483f9e57 composer install;

cd laradock || exit
docker-compose down
