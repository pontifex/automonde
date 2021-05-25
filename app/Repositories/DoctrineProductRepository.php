<?php

namespace App\Repositories;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductRepository implements IProductRepository
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function addOne(
        Product $product
    ) {
        $this->em->persist($product);
        $this->em->flush();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Product
    {
        /** @var Product|null $product */
        $product = $this->em->find(Product::class, $id);

        if (null === $product) {
            throw new ResourceNotFoundException();
        }

        return $product;
    }

    public function list(int $pageNumber, int $pageSize): Collection
    {
        $productsArr = $this->em->getRepository(Product::class)
            ->findBy([], null, $pageSize, ($pageNumber - 1) * $pageSize);

        return new ArrayCollection($productsArr);
    }
}
