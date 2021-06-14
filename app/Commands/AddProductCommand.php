<?php

namespace App\Commands;

class AddProductCommand
{
    public function __construct(
        private string $id,
        private string $description,
        private int $mileageDistance,
        private string $mileageUnit,
        private int $priceAmount,
        private string $priceCurrency,
        private string $modelId
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMileageDistance(): int
    {
        return $this->mileageDistance;
    }

    public function getMileageUnit(): string
    {
        return $this->mileageUnit;
    }

    public function getPriceAmount(): int
    {
        return $this->priceAmount;
    }

    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }

    public function getModelId(): string
    {
        return $this->modelId;
    }
}
