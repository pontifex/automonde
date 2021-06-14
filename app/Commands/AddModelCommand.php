<?php

namespace App\Commands;

class AddModelCommand
{
    public function __construct(
        private string $id,
        private string $name,
        private string $brandId
    ) {}

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
