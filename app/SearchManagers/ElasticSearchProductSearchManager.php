<?php

namespace App\SearchManagers;

use App\Domain\Entities\Product;
use App\Hydrators\ArrayProductHydrator;
use App\Hydrators\Hydrate;
use App\Hydrators\SearchProductHydrator;
use Elasticsearch\Client;
use stdClass;

class ElasticSearchProductSearchManager implements IProductSearchManager
{
    use Hydrate;

    public function __construct(
        private Client $client,
        private ArrayProductHydrator $arrayProductHydrator,
        private SearchProductHydrator $searchProductHydrator
    ) { }

    public function addOne(Product $product)
    {
        $params = [
            'index' => 'products',
            'id'    => $product->getId(),
            'body'  => [
                'description' => $product->getDescription(),
                'price_amount' => $product->getPrice()->getAmount(),
                'mileage_distance' => $product->getMileage()->getDistance(),
            ],
        ];

        $this->client->index($params);
    }

    public function getOneById(string $id): Product
    {
        $params = [
            'index' => 'products',
            'id'    => $id
        ];

        $response = $this->client->getSource($params);
        $response['id'] = $id;

        /** @var Product $product */
        $product = $this->hydrate($this->arrayProductHydrator, $response);

        return $product;
    }

    public function list(array $criteria = [], string $orderBy = null, int $limit = 15, int $offset = 0): array
    {
        $params = [
            'index' => 'products',
            'body' => [
                'query' => [
                    'match_all' => new stdClass()
                ],
            ],
            'size' => $limit,
            'from'  => $offset,
        ];

        $response = $this->client->search($params);

        $products = [];
        foreach ($response['hits']['hits'] as $hit) {
            $products[] = $this->hydrate(
                $this->searchProductHydrator,
                $hit
            );
        }

        return $products;
    }
}
