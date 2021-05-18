<?php

namespace App\Domain\Entities;

use Doctrine\ORM\Mapping AS ORM;
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
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $slug;

    public function __construct(
        UuidInterface $id,
        string $name,
        string $slug
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
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

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
        ];
    }
}
