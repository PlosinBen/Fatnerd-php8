<?php

namespace App\Repository;

use App\Contracts\InstanceTrait;
use App\Contracts\Repository;
use App\lib\Decimal;
use App\Models\Statement;
use Carbon\Carbon;

class StatementRepository extends Repository
{
    use InstanceTrait;

    public function create(Carbon $period): Statement
    {
        return Statement::firstOrCreate([Statement::PERIOD => $period]);
    }

    public function update(
        Carbon                   $period,
        string|int|float|Decimal $commitment,
        int|float                $weight,
        string|int|float|Decimal $profit
    ): Statement
    {
        return Statement::updateOrCreate(
            [
                Statement::PERIOD => $period
            ],
            [
                Statement::COMMITMENT => $commitment,
                Statement::WEIGHT => $weight,
                Statement::PROFIT => $profit,
                Statement::PROFIT_PER_WEIGHT => Decimal::make($profit)->div($profit)
            ]
        );
    }
}
