<?php

namespace App\Commands;

class AddProductCommand
{
    /** @var string */
    private $id;

    /** @var string */
    private $description;

    /** @var int */
    private $mileageDistance;

    /** @var string */
    private $mileageUnit;

    /** @var int */
    private $priceAmount;

    /** @var string */
    private $priceCurrency;

    /** @var string */
    private $modelId;

    public function __construct(
        string $id,
        string $description,
        int $mileageDistance,
        string $mileageUnit,
        int $priceAmount,
        string $priceCurrency,
        string $modelId
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->mileageDistance = $mileageDistance;
        $this->mileageUnit = $mileageUnit;
        $this->priceAmount = $priceAmount;
        $this->priceCurrency = $priceCurrency;
        $this->modelId = $modelId;
    }

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
