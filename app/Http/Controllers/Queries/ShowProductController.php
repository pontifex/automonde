<?php

namespace App\Http\Controllers\Queries;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IProductRepository;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Libs\Api\Fields\Exceptions\IncorrectFieldException;
use Libs\Api\Fields\Exceptions\NoFieldsException;
use Libs\Api\Fields\Fields;
use Libs\Api\IApi;
use Libs\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowProductController extends BaseController
{
    use Debug;
    use Fields;
    use Serialize;

    /** @var IProductRepository */
    private $productRepository;

    /** @var ISerializer */
    private $serializer;

    public function __construct(
        IProductRepository $productRepository,
        ISerializer $serializer
    ) {
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
    }

    /**
     * @throws IncorrectFieldException
     * @throws NoFieldsException
     * @throws ResourceNotFoundException
     */
    public function index(Request $request, string $id): Response
    {
        $fields = $this->getFields(
            $request->get(IApi::FIELDS_PARAM, []),
            $this->serializer->getType(),
            Product::getAllowedFields()
        );

        try {
            $brand = $this->productRepository->getOneById($id);
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->debugException($e);
            throw new ResourceNotFoundException();
        }

        return new JsonResponse(
            $this->serialize($this->serializer, $brand, $fields)
        );
    }
}
