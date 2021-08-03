<?php

namespace App\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use Illuminate\Contracts\Validation\Rule;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class ExistingBrand implements Rule
{
    public function __construct(
        private IBrandRepository $brandRepository
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
            $this->brandRepository->getOneById($value);
        } catch (ResourceNotFoundException) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return 'Brand not exist';
    }
}
