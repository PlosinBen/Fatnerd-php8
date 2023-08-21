<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ModelPeriodTrait
{
    protected function periodCarbon(): Attribute
    {
        return Attribute::make(
            get: fn(string $period, array $attributes) => Carbon::createFromFormat('Ym', $attributes['period']),
        );
    }

    protected function period(): Attribute
    {
        return Attribute::make(
            get: fn($period) => (string)$period,
            set: fn(string|int|Carbon $period) => $period instanceof Carbon ? $period->format('Ym') : $period,
        );
    }
}
