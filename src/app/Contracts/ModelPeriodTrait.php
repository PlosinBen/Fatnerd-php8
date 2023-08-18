<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ModelPeriodTrait
{
    protected function period(): Attribute
    {
        return Attribute::make(
            get: fn(string $period) => Carbon::parse($period),
            set: fn(Carbon $period) => $period->format('Ym'),
        );
    }
}
