### Doctrine support

```https://github.com/laravel-doctrine/orm```

### Local machine steps
- (assuming you are in automonde/laradock dir) 
cp .env.example .env
- ```docker-compose up -d nginx mysql redis elasticsearch```
- ```docker exec -it automonde_workspace_1 bash```
- ```composer install```
- ```php artisan doctrine:generate:proxies```
- ```php artisan horizon```

### Horizon
Horizon is available on http://localhost/horizon

### Elasticsearch
Recreate index for products: ```php artisan elasticsearch:index:recreate products```

### Unit tests
```phpunit```
