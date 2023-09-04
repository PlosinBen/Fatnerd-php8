<?php

namespace App\DataCalculator;

use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Models\InvestMonthlyBalance;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * @property-read Collection $accounts
 */
class StatementProfitCalculator
{
    protected Carbon $period;

    protected Collection $accounts;

    public static function make(Carbon $period): ?StatementProfitCalculator
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

    public function pushAccount(Collection $accountCollection): self
    {
        $this->accounts = $accountCollection->filter(fn($item) => $item instanceof InvestAccount);

        return $this;
    }

    public function putPreBalance(Decimal $decimal)
    {

    }
}
