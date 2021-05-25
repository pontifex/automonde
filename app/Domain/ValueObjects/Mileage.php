<?php

namespace App\Domain\ValueObjects;

use App\Exceptions\DomainException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
final class Mileage
{
    public const UNIT_MILES = 'mi';
    public const UNIT_KILOMETERS = 'km';

    /**
     * @ORM\Column(type="integer")
     */
    private $distance;

    /**
     * @ORM\Column(type="string")
     */
    private $unit;

    /**
     * @var array
     */
    public static $validUnits = [self::UNIT_KILOMETERS, self::UNIT_MILES];

    public function __construct(
        int $distance,
        string $unit
    ) {
        if (!in_array($unit, self::$validUnits)) {
            throw new DomainException('The Mileage unit is not valid!');
        }

        $this->distance = $distance;
        $this->unit = $unit;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}
