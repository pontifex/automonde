<?php

namespace App\Domain\Entities;

interface ISerializable
{
    public function getId(): string;

    public static function getAllowedFields(): array;
}
