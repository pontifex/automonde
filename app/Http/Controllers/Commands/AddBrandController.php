<?php

namespace App\Http\Controllers\Commands;

use App\Commands\AddBrandCommand;
use App\Http\Requests\AddBrand as AddBrandRequest;
use App\Jobs\AddBrand;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddBrandController extends BaseController
{
    use DispatchesJobs;
    use Serialize;

    public function __construct(
        private ISerializer $serializer
    ) {
    }

    public function index(AddBrandRequest $request): Response
    {
        $id = Uuid::uuid4()->toString();

        $command = new AddBrandCommand(
            $id,
            $request->get($this->serializer->getType())['name']
        );

        $this->dispatch(
            new AddBrand($command)
        );

        return new JsonResponse(
            $this->serializeId($this->serializer, $id)
        );
    }
}
