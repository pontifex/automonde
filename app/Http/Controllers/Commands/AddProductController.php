<?php

namespace App\Http\Controllers\Commands;

use App\Commands\AddProductCommand;
use App\Http\Requests\AddProduct as AddProductRequest;
use App\Jobs\AddProduct;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddProductController extends BaseController
{
    use DispatchesJobs;
    use Serialize;

    public function __construct(
        private ISerializer $serializer
    ) {}

    public function index(AddProductRequest $request): Response
    {
        $id = Uuid::uuid4()->toString();

        $command = new AddProductCommand(
            $id,
            $request->get($this->serializer->getType())['description'],
            $request->get($this->serializer->getType())['mileage_distance'],
            $request->get($this->serializer->getType())['mileage_unit'],
            $request->get($this->serializer->getType())['price_amount'],
            $request->get($this->serializer->getType())['price_currency'],
            $request->get($this->serializer->getType())['model_id'],
        );

        $this->dispatch(
            new AddProduct($command)
        );

        return new JsonResponse(
            $this->serializeId($this->serializer, $id)
        );
    }
}
