<?php

namespace App\Rules;

use App\Repositories\IBrandRepository;
use Illuminate\Contracts\Validation\Rule;
use Libs\Slug\Slug;

class UniqueBrand implements Rule
{
    use Slug;

    /** @var IBrandRepository */
    private $brandRepository;

    public function __construct(
        IBrandRepository $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
    }

    public function passes($attribute, $value): bool
    {
        return $this->brandRepository->isUniqueBySlug($this->slug($value));
    }

    public function message(): string
    {
        return 'Brand already exists';
    }
}
