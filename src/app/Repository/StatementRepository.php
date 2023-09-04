<?php

namespace App\Repository;

use App\Contracts\InstanceTrait;
use App\Contracts\Repository;
use App\lib\Decimal;
use App\Models\Statement;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class StatementRepository extends Repository
{
    use InstanceTrait;

    public function fetch(): LengthAwarePaginator
    {
        return Statement::orderBy(Statement::PERIOD, 'desc')->paginate(20);
    }

    public function create(string $period): Statement
    {
        return Statement::firstOrCreate([Statement::PERIOD => $period]);
    }

    public function update(
        Carbon $period,
        string $commitment = null,
        string $weight = null,
        string $profitPerWeight = null,
        string $profit = null
    ): Statement
    {

        return Statement::updateOrCreate(
            [
                Statement::PERIOD => $period->format('Ym')
            ],
            array_filter([
                Statement::COMMITMENT => $commitment,
                Statement::WEIGHT => $weight,
                Statement::PROFIT => $profit,
                Statement::PROFIT_PER_WEIGHT => $profitPerWeight,
            ])
        );
    }
}
