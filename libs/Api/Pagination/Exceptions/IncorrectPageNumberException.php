<?php

namespace Libs\Api\Pagination\Exceptions;

use Exception;

class IncorrectPageNumberException extends Exception implements IPaginationException
{
    protected $message = 'Page number must be higher than 0';
}
