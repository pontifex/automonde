<?php

namespace App\Http\Controllers\Queries;

use App\Services\BrandService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowBrandController extends BaseController
{
    use DispatchesJobs;

    /** @var BrandService */
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(string $id): Response
    {
        if (null === $id) {
            return new JsonResponse(
                [
                    'errors' => [
                        'Not found',
                    ],
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $brand = $this->brandService->getBrandById($id);

        if (null === $brand) {
            return new JsonResponse(
                [
                    'errors' => [
                        'Not found',
                    ],
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            [
                'id' => $brand->getId(),
                'name' => $brand->getName(),
            ]
        );
    }
}
