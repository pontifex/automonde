#!/usr/bin/env bash

cp .env.example .env

cd laradock || exit
cp ../.env.laradock .env
ls -la
cp laravel-horizon/supervisord.d/laravel-horizon.conf.example laravel-horizon/supervisord.d/laravel-horizon.conf
docker-compose up -d nginx mysql redis elasticsearch laravel-horizon
cd ..

CONTAINER_WORKSPACE_NAME=$(docker ps -af "ancestor=automonde_workspace" --format "{{.Names}}")
CONTAINER_MYSQL_NAME=$(docker ps -af "ancestor=automonde_mysql" --format "{{.Names}}")
CONTAINER_REDIS_NAME=$(docker ps -af "ancestor=automonde_redis" --format "{{.Names}}")
CONTAINER_ELASTIC_SEARCH_NAME=$(docker ps -af "ancestor=automonde_elasticsearch" --format "{{.Names}}")
CONTAINER_ELASTIC_SEARCH_NAME=$(docker ps -af "ancestor=automonde_elasticsearch" --format "{{.Names}}")

docker ps

sed -i "s/DB_HOST=automonde_mysql_1/DB_HOST=$CONTAINER_MYSQL_NAME/g" .env
sed -i "s/REDIS_HOST=automonde_redis_1/REDIS_HOST=$CONTAINER_REDIS_NAME/g" .env
sed -i "s/ELASTICSEARCH_HOST=automonde_elasticsearch_1/ELASTICSEARCH_HOST=$CONTAINER_ELASTIC_SEARCH_NAME/g" .env

sleep 30

docker exec "$CONTAINER_MYSQL_NAME" mysql -proot -e "CREATE DATABASE automonde"

docker exec "$CONTAINER_WORKSPACE_NAME" composer install;
docker exec "$CONTAINER_WORKSPACE_NAME" php artisan doctrine:migrations:migrate;
docker exec "$CONTAINER_WORKSPACE_NAME" php artisan doctrine:generate:proxies;
docker exec "$CONTAINER_WORKSPACE_NAME" vendor/bin/phpunit;
docker exec "$CONTAINER_WORKSPACE_NAME" php artisan health-check/elasticsearch;
docker exec "$CONTAINER_WORKSPACE_NAME" php artisan health-check/redis;

docker exec "$CONTAINER_WORKSPACE_NAME" npm install -g newman
docker exec "$CONTAINER_WORKSPACE_NAME" newman run https://www.getpostman.com/collections/b40e04b298235fc48c35

cd laradock || exit
docker-compose down
