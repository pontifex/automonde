#!/usr/bin/env bash

cd laradock || exit
docker-compose up -d nginx mysql redis elasticsearch
cd ..

docker ps

docker exec -it container_phpfpm_vloerkledenwinkel composer install;

cd laradock || exit
docker-compose down
