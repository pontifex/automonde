<?php

namespace App\Rules;

use App\Repositories\IBrandRepository;
use Illuminate\Contracts\Validation\Rule;
use Libs\Slug\Slug;

class UniqueBrand implements Rule
{
    use Slug;

    public function __construct(
        private IBrandRepository $brandRepository
    ) {
    }

    public function passes($attribute, mixed $value): bool
    {
        return $this->brandRepository->isUniqueBySlug($this->slug($value));
    }

    public function message(): string
    {
        return 'Brand already exists';
    }
}
