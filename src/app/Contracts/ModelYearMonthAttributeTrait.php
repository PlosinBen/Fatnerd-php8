<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ModelYearMonthAttributeTrait
{
    protected function yearMonthAttribute(): Attribute
    {
        return Attribute::make(
            get: fn($period) => $period === null ? null : (string)$period,
            set: fn(string|int|Carbon $period) => $period instanceof Carbon ? $period->format('Ym') : $period,
        );
    }
}
