<?php

namespace App\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IModelRepository;
use Illuminate\Contracts\Validation\Rule;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class ExistingModel implements Rule
{
    public function __construct(
        private IModelRepository $modelRepository
    ) {
    }

    public function passes($attribute, mixed $value): bool
    {
        try {
            Uuid::fromString($value);
        } catch (InvalidUuidStringException) {
            return false;
        }

        try {
            $this->modelRepository->getOneById($value);
        } catch (ResourceNotFoundException) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return 'Model not exist';
    }
}
