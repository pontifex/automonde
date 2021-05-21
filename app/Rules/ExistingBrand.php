<?php

namespace App\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use Illuminate\Contracts\Validation\Rule;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class ExistingBrand implements Rule
{
    /** @var IBrandRepository */
    private $brandRepository;

    public function __construct(
        IBrandRepository $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
    }

    public function passes($attribute, $value): bool
    {
        try {
            Uuid::fromString($value);
        } catch (InvalidUuidStringException $e) {
            return false;
        }

        try {
            $this->brandRepository->getOneById($value);
        } catch (ResourceNotFoundException $e) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return 'Brand not exist';
    }
}
