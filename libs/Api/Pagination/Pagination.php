<?php

namespace Libs\Api\Pagination;

use Libs\Api\Pagination\Exceptions\IncorrectPageNumberException;
use Libs\Api\Pagination\Exceptions\IncorrectPageSizeException;

trait Pagination
{
    /**
     * @throws IncorrectPageNumberException
     * @throws IncorrectPageSizeException
     */
    public function extractPaginationParams(
        array $pageArr,
        int $defaultNumber,
        int $defaultSize
    ): array
    {
        $pageNumber = (isset($pageArr['number']))
            ? (int) $pageArr['number']
            : $defaultNumber;

        if ($pageNumber <= 0) {
            throw new IncorrectPageNumberException();
        }

        $pageSize = (isset($pageArr['size']))
            ? (int) $pageArr['size']
            : $defaultSize;

        if ($pageSize <= 0) {
            throw new IncorrectPageSizeException();
        }

        return [$pageNumber, $pageSize];
    }
}
