<?php

namespace App\Exceptions;

class ResourceNotFoundException extends \Exception implements IApiException
{
    protected $message = 'Not found';
}
