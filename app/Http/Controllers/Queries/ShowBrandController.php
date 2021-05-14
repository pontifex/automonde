<?php

namespace App\Http\Controllers\Queries;

use App\Exceptions\ResourceNotFoundException;
use App\Serializers\BrandSerializer;
use App\Services\BrandService;
use App\Services\Debug;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowBrandController extends BaseController
{
    use Debug, DispatchesJobs;

    /** @var BrandService */
    private $brandService;

    /** @var BrandSerializer */
    private $serializer;

    public function __construct(
        BrandService $brandService,
        BrandSerializer $serializer
    )
    {
        $this->brandService = $brandService;
        $this->serializer = $serializer;
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function index(string $id): Response
    {
        try {
            $brand = $this->brandService->getBrandById($id);
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->debugException($e);
            throw new ResourceNotFoundException();
        }

        return new JsonResponse(
            $this->serializer->serialize($brand)
        );
    }
}
