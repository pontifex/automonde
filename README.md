### Doctrine support

```https://github.com/laravel-doctrine/orm```

### Local machine steps
- (assuming you are in automonde/laradock dir) ```docker-compose up -d nginx mysql redis elasticsearch```
- ```docker exec -it automonde_workspace_1 bash```
- ```php artisan horizon```

### Horizon
Horizon is available on http://localhost/horizon

### Elasticsearch
Create index for products: ```php artisan elasticsearch:index:create products```
