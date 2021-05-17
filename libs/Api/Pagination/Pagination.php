<?php

namespace Libs\Api\Pagination;

trait Pagination
{
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
            throw new \LogicException('Page number must be higher than 0');
        }

        $pageSize = (isset($pageArr['size']))
            ? (int) $pageArr['size']
            : $defaultSize;

        if ($pageSize <= 0) {
            throw new \LogicException('Page size must be higher than 0');
        }

        return [$pageNumber, $pageSize];
    }
}
