#!/usr/bin/env bash

cd laradock || exit
docker-compose up -d nginx mysql redis elasticsearch
cd ..

docker ps

docker exec -it automonde_workspace_1 composer install;

cd laradock || exit
docker-compose down
