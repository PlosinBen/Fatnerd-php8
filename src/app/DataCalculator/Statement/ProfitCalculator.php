<?php

namespace App\DataCalculator\Statement;

use App\lib\Decimal;
use Carbon\Carbon;

/**
 * @property-read Decimal $commitment
 * @property-read Decimal $weight
 * @property-read Decimal $profit
 */
class ProfitCalculator
{
    protected Carbon $period;

    protected Decimal $commitment;

    protected Decimal $weight;

    protected Decimal $profit;

    public static function make(Carbon $period): ?ProfitCalculator
    {
        return app()->make(static::class, ['period' => $period]);
    }

    public function __construct(Carbon $period)
    {
        $this->period = $period;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function setCommitment(Decimal $commitment): self
    {
        $this->commitment = $commitment;

        $this->weight = $this->commitment->div(5000)->floor()->max(0.5);

        return $this;
    }

    public function setProfitPerWeight(Decimal $profitPerWeight): self
    {
        $this->profit = $profitPerWeight->mul($this->weight)->floor();

        return $this;
    }

    public function replenishAdminProfit(Decimal $profit): self
    {
        $this->profit = $this->profit->add($profit);

        return $this;
    }
}
