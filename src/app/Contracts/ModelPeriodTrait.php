<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ModelPeriodTrait
{
    use ModelYearMonthAttributeTrait;

    protected function periodCarbon(): Attribute
    {
        return Attribute::make(
            get: fn(string $period, array $attributes) => Carbon::createFromFormat('Ym', $attributes['period']),
        );
    }

    protected function period(): Attribute
    {
        return $this->yearMonthAttribute();
    }

    public function scopePeriod(Builder $query, Carbon $period): void
    {
        $query->where('period', $period->format('Ym'));
    }
}
