<?php

namespace App\Domain\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity
 * @ORM\Table(name="brands")
 */
class Brand
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

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        if ($this->id instanceof UuidInterface) {
            return $this->id->toString();
        }

        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
