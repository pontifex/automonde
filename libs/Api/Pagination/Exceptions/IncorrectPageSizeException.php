<?php

namespace Libs\Api\Pagination\Exceptions;

use Exception;

class IncorrectPageSizeException extends Exception implements IPaginationException
{
    protected $message = 'Page size must be higher than 0';
}
