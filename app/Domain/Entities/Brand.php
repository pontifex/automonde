<?php

namespace App\Domain\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity
 * @ORM\Table(name="brands")
 */
class Brand implements IHydrateable, ISerializable
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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="brand")
     */
    private $models;

    public function __construct(
        UuidInterface $id,
        string $name,
        string $slug
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;

        $this->models = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getModels(): ArrayCollection
    {
        return $this->models;
    }

    public function addModel(Model $model): void
    {
        if (! $this->models->contains($model)) {
            $this->models[] = $model;
            $model->setBrand($this);
        }
    }

    public function removeModel(Model $model): void
    {
        if ($this->models->contains($model)) {
            $this->models->removeElement($model);

            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }
    }

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
        ];
    }
}
