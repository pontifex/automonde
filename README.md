### Description
Project is a back-end RESTfull (with custom enhancements) API for car classified app.

### Technology:
- PHP8 + Laravel8 + Doctrine2 (not Eloquent!) + MySQL8
- ElasticSearch to handle classified searching
- Horizon + Redis to handle time-consuming jobs
- Redis as a cache layer

### Doctrine support
```https://github.com/laravel-doctrine/orm```

### Local machine steps
- (assuming you are in automonde/laradock dir) ```cp .env.example .env```
- ```cp laravel-horizon/supervisor.d/laravel-horizon.conf.example laravel-horizon/supervisor.d/laravel-horizon.conf```
- ```docker-compose up -d nginx mysql redis elasticsearch laravel-horizon```
- ```docker exec -it automonde_workspace_1 bash```
- ```composer install```
- ```php artisan doctrine:migrations:migrate```
- ```php artisan doctrine:generate:proxies```
- ```php artisan elasticsearch:index:recreate products```

### Horizon
Horizon is available on http://localhost/horizon

### Elasticsearch
Recreate index for products: ```php artisan elasticsearch:index:recreate products```

Indexing products ```php artisan elasticsearch:indexing:products```

### Unit tests
```phpunit```

### Endpoints
- ```POST /brands``` Add brand
- ```GET /brands/{id}``` Show brand
- ```GET /brands``` List brands
- ```POST /models``` Add model
- ```POST /products``` Add product
- ```GET /products/{id}``` Show product
- ```GET /products``` List products
