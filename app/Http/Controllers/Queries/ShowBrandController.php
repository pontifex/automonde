<?php

namespace App\Http\Controllers\Queries;

use App\Exceptions\ResourceNotFoundException;
use App\Serializers\BrandSerializer;
use App\Serializers\Serialize;
use App\Services\BrandService;
use Illuminate\Routing\Controller as BaseController;
use Libs\Api\Fields\Exceptions\NoFieldsException;
use Libs\Api\Fields\Fields;
use Libs\Api\IApi;
use Libs\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Libs\Api\Fields\Exceptions\IncorrectFieldException;

class ShowBrandController extends BaseController
{
    use Debug, Fields, Serialize;

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
    public function index(Request $request, string $id): Response
    {
        $fields = $this->getFields(
            $request->get(IApi::FIELDS_PARAM, []),
            $this->serializer->getType(),
            $this->brandService->getAllowedFields()
        );

        try {
            $brand = $this->brandService->getBrandById($id);
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->debugException($e);
            throw new ResourceNotFoundException('Not found');
        }

        return new JsonResponse(
            $this->serialize($this->serializer, $brand, $fields)
        );
    }
}
