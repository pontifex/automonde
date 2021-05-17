<?php

namespace App\Rules;

use App\Domain\Entities\Brand;
use Libs\Slug\Slug;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Validation\Rule;

class UniqueBrand implements Rule
{
    use Slug;

    /** @var EntityManager */
    private $em;

    public function __construct(
        EntityManager $em
    )
    {
        $this->em = $em;
    }

    public function passes($attribute, $value): bool
    {
        $q = $this->em->createQueryBuilder()
            ->select('count(b.id)')
            ->from(Brand::class, 'b')
            ->where('b.slug = :brandName')
            ->setParameter('brandName', $this->slug($value))
            ->getQuery();

        return ((int) $q->getSingleScalarResult() === 0);
    }

    public function message(): string
    {
        return 'Brand already exists';
    }
}
