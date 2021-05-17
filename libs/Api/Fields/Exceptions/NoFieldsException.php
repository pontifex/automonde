<?php

namespace Libs\Api\Fields\Exceptions;

use App\Exceptions\IApiException;
use Exception;

class NoFieldsException extends Exception implements IApiException
{
}
