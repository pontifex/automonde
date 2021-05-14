<?php

namespace App\Http\Controllers\Commands;

use App\Commands\AddBrandCommand;
use App\Jobs\AddBrand;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddBrandController extends BaseController
{
    use DispatchesJobs;

    public function index(): Response
    {
        $id = Uuid::uuid4()->toString();

        $command = new AddBrandCommand(
            $id,
            sprintf('Volvo_%d', rand(1, 10000))
        );

        $this->dispatch(
            new AddBrand($command)
        );

        return new JsonResponse(
            [
                'id' => $id,
            ]
        );
    }
}