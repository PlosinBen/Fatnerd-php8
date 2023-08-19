<?php

namespace App\Contracts;

use App\lib\Decimal;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ModelDecimalAttributeTrait
{
    protected function decimalAttribute(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Decimal::make($value),
            set: fn($value) => (string)($value ?? 0),
        );
    }
}
