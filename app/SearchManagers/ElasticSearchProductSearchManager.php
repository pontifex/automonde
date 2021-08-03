<?php

namespace App\SearchManagers;

use App\Domain\Entities\Product;
use App\Hydrators\ArrayProductHydrator;
use App\Hydrators\Hydrate;
use App\Hydrators\SearchProductHydrator;
use App\Serializers\Search\ProductIndexingSerializer;
use App\Serializers\Serialize;
use Elasticsearch\Client;
use Libs\Debug\Debug;
use stdClass;

class ElasticSearchProductSearchManager implements IProductSearchManager
{
    use Hydrate;
    use Serialize;
    use Debug;

    public function __construct(
        private Client $client,
        private ArrayProductHydrator $arrayProductHydrator,
        private SearchProductHydrator $searchProductHydrator,
        private ProductIndexingSerializer $productIndexingSerializer
    ) {
    }

    public function addOne(Product $product)
    {
        $params = $this->serialize(
            $this->productIndexingSerializer,
            $product,
            []
        );

        $this->client->index($params[ProductIndexingSerializer::getType()]);
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
