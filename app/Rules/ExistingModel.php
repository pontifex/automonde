<?php

namespace App\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IModelRepository;
use Illuminate\Contracts\Validation\Rule;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class ExistingModel implements Rule
{
    /** @var IModelRepository */
    private $modelRepository;

    public function __construct(
        IModelRepository $modelRepository
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function passes($attribute, $value): bool
    {
        try {
            Uuid::fromString($value);
        } catch (InvalidUuidStringException $e) {
            return false;
        }

        try {
            $this->modelRepository->getOneById($value);
        } catch (ResourceNotFoundException $e) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return 'Model not exist';
    }
}
