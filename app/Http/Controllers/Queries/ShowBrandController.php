<?php

namespace App\Http\Controllers\Queries;

use App\Exceptions\ResourceNotFoundException;
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

    /**
     * @throws ResourceNotFoundException
     */
    public function index(string $id): Response
    {
        try {
            $brand = $this->brandService->getBrandById($id);
        } catch (\Exception $e) {
            throw new ResourceNotFoundException();
        }

        return new JsonResponse(
            [
                'id' => $brand->getId(),
                'name' => $brand->getName(),
            ]
        );
    }
}
