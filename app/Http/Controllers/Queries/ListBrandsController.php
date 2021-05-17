<?php

namespace App\Http\Controllers\Queries;

use App\Exceptions\ResourceNotFoundException;
use App\Serializers\BrandSerializer;
use App\Serializers\Serialize;
use App\Services\BrandService;
use Illuminate\Routing\Controller as BaseController;
use Libs\Api\Fields\Exceptions\IncorrectFieldException;
use Libs\Api\Fields\Exceptions\NoFieldsException;
use Libs\Api\Fields\Fields;
use Libs\Api\IApi;
use Libs\Api\Pagination\Pagination;
use Libs\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListBrandsController extends BaseController
{
    use Debug, Fields, Pagination, Serialize;

    private const DEFAULT_PAGE_NUMBER = 1;
    private const DEFAULT_SIZE = 15;

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
     * @throws IncorrectFieldException
     * @throws NoFieldsException
     * @throws ResourceNotFoundException
     */
    public function index(Request $request): Response
    {
        [$pageNumber, $pageSize] = $this->extractPaginationParams(
            $request->get(IApi::FIELDS_PARAM, []),
            self::DEFAULT_PAGE_NUMBER,
            self::DEFAULT_SIZE
        );

        $fields = $this->getFields(
            $request->get(IApi::FIELDS_PARAM, []),
            $this->serializer->getType(),
            $this->brandService->getAllowedFields()
        );

        try {
            $brands = $this->brandService->listBrands(
                $pageNumber,
                $pageSize
            );
        } catch (\Exception $e) {
            $this->debugException($e);
            throw new ResourceNotFoundException('Not found');
        }

        return new JsonResponse(
            $this->serializeCollection(
                $this->serializer,
                $brands,
                $fields
            )
        );
    }
}
