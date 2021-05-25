<?php

namespace App\Domain\ValueObjects;

use App\Exceptions\DomainException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
final class Price
{
    public const CURRENCY_EUR = 'EUR';
    public const CURRENCY_USD = 'USD';

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="string")
     */
    private $currency;

    /**
     * @var array
     */
    public static $validCurrencies = [self::CURRENCY_EUR, self::CURRENCY_USD];

    public function __construct(
        int $amount,
        string $currency
    ) {
        if (!in_array($currency, self::$validCurrencies)) {
            throw new DomainException('The Price currency is not valid!');
        }

        if ($amount <= 0) {
            throw new DomainException('The Price amount is not valid!');
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
