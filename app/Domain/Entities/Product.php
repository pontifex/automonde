<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product implements IHydrateable, ISerializable
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Embedded(class="App\Domain\ValueObjects\Mileage")
     */
    private $mileage;

    /**
     * @ORM\Embedded(class="App\Domain\ValueObjects\Price")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Model", inversedBy="products")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    private $model;

    public function __construct(
        UuidInterface $id,
        Mileage $mileage,
        Price $price,
        string $description
    ) {
        $this->id = $id;
        $this->mileage = $mileage;
        $this->price = $price;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMileage(): Mileage
    {
        return $this->mileage;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getModel(): ?Brand
    {
        return $this->model;
    }

    public function setModel(?Model $model): void
    {
        $this->model = $model;
    }

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'description',
            'mileage',
            'price'
        ];
    }
}
