<?php

namespace App\Commands;

class AddModelCommand
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $brandId;

    public function __construct(
        string $id,
        string $name,
        string $brandId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->brandId = $brandId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBrandId(): string
    {
        return $this->brandId;
    }
}
