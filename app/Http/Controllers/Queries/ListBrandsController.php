<?php

namespace App\Http\Controllers\Queries;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Libs\Api\Fields\Exceptions\IncorrectFieldException;
use Libs\Api\Fields\Exceptions\NoFieldsException;
use Libs\Api\Fields\Fields;
use Libs\Api\IApi;
use Libs\Api\Pagination\Exceptions\IncorrectPageNumberException;
use Libs\Api\Pagination\Exceptions\IncorrectPageSizeException;
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

    /** @var IBrandRepository */
    private $brandRepository;

    /** @var ISerializer */
    private $serializer;

    public function __construct(
        IBrandRepository $brandRepository,
        ISerializer $serializer
    )
    {
        $this->brandRepository = $brandRepository;
        $this->serializer = $serializer;
    }

    /**
     * @throws IncorrectFieldException
     * @throws NoFieldsException
     * @throws ResourceNotFoundException
     * @throws IncorrectPageNumberException
     * @throws IncorrectPageSizeException
     */
    public function index(Request $request): Response
    {
        [$pageNumber, $pageSize] = $this->extractPaginationParams(
            $request->get(IApi::PAGE_PARAM, []),
            self::DEFAULT_PAGE_NUMBER,
            self::DEFAULT_SIZE
        );

        $fields = $this->getFields(
            $request->get(IApi::FIELDS_PARAM, []),
            $this->serializer->getType(),
            $this->brandRepository->getAllowedFields()
        );

        try {
            $brands = $this->brandRepository->list(
                $pageNumber,
                $pageSize
            );
        } catch (Exception $e) {
            $this->debugException($e);
            throw new ResourceNotFoundException();
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
