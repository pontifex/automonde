<?php

namespace App\CacheManagers\Exceptions;

use RuntimeException;

class NotExistException extends RuntimeException
{
    protected $message = 'Not in cache';
}
