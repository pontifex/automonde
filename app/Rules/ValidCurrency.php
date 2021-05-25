<?php

namespace App\Rules;

use App\Domain\ValueObjects\Price;
use Illuminate\Contracts\Validation\Rule;

class ValidCurrency implements Rule
{
    public function passes($attribute, $value): bool
    {
        return in_array($value, Price::$validCurrencies);
    }

    public function message(): string
    {
        return 'Currency is invalid';
    }
}
