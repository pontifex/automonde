<?php

namespace App\Rules;

use App\Domain\ValueObjects\Mileage;
use Illuminate\Contracts\Validation\Rule;

class ValidMileageUnit implements Rule
{
    public function passes($attribute, mixed $value): bool
    {
        return in_array($value, Mileage::$validUnits);
    }

    public function message(): string
    {
        return 'Mileage unit is invalid';
    }
}
