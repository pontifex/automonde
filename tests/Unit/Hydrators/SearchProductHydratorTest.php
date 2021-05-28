<?php

namespace Tests\Unit\Hydrators;

use App\Domain\Entities\Product;
use App\Hydrators\Hydrate;
use App\Hydrators\SearchProductHydrator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SearchProductHydratorTest extends TestCase
{
    use Hydrate;

    public function testHydrate()
    {
        $hydrator = app()->get(SearchProductHydrator::class);

        $data = [
            '_id' => Uuid::uuid4()->toString(),
            '_source' => [
                'mileage_distance' => 198000,
                'price_amount' => 14000,
                'description' => 'Super car, buy it!'
            ]
        ];

        /** @var Product $product */
        $product = $this->hydrate($hydrator, $data);

        $this->assertSame($data['_id'], $product->getId());
        $this->assertSame($data['_source']['mileage_distance'], $product->getMileage()->getDistance());
        $this->assertSame($data['_source']['price_amount'], $product->getPrice()->getAmount());
        $this->assertSame($data['_source']['description'], $product->getDescription());
    }
}
