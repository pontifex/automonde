<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Libs\Api\Fields\Exceptions\IFieldsException;
use Libs\Api\Pagination\Exceptions\IPaginationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ResourceNotFoundException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (
            $e instanceof IApiException
            || $e instanceof IFieldsException
            || $e instanceof IPaginationException
        ) {
            return new JsonResponse(
                [
                    'errors' => [
                        $e->getMessage(),
                    ],
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return parent::render($request, $e);
    }
}
