<?php

namespace App\Indexers;

use App\Domain\Entities\Product;
use App\Repositories\DoctrineProductRepository;
use App\Serializers\Search\ProductBulkIndexingSerializer;
use App\Serializers\Serialize;
use Elasticsearch\Client;

class ElasticSearchBulkProductsIndexer implements IIndexer
{
    private const PER_PAGE = 1000;
    private const INDEX_PRODUCTS = 'products';

    use Serialize;

    public function __construct(
        private DoctrineProductRepository $doctrineProductRepository,
        private Client $client,
        private ProductBulkIndexingSerializer $productBulkIndexingSerializer
    ) { }

    public function index(): int
    {
        $total = 0;
        $pageNumber = 1;

        $collection = $this->doctrineProductRepository->list(
            $pageNumber,
            self::PER_PAGE
        );

        while ($collection->count()) {
            $pageNumber++;

            $params = [];
            $body = [];
            foreach ($collection as $product) {
                /** @var Product $product */

                $body = $this->serialize(
                    $this->productBulkIndexingSerializer,
                    $product,
                    []
                );

                $total++;
            }

            $params['body'] = $body[ProductBulkIndexingSerializer::getType()];
            $this->client->bulk($params);

            $collection = $this->doctrineProductRepository->list(
                $pageNumber,
                self::PER_PAGE
            );
        };

        return $total;
    }
}
