<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\lib\Decimal;
use App\Models\StatementFutures;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static StatementFuturesRepository make()
 */
class StatementFuturesRepository extends Repository
{
    public function get(int $id)
    {

    }

    public function fetchByPeriodGroup(Carbon $period, string $group): ?StatementFutures
    {
        return StatementFutures::where(StatementFutures::PERIOD, $period->format('Ym'))
            ->where(StatementFutures::GROUP, $group)
            ->first();
    }

    public function fetchList()
    {
        return StatementFutures::orderBy(StatementFutures::PERIOD, 'DESC')->paginate(20);
    }

    public function insert(
        string                   $group,
        Carbon                   $period,
        string|int|float|Decimal $commitment,
        string|int|float|Decimal $openProfit,
        int|float|Decimal|null   $closeProfit,
        string|int|float|Decimal $deposit,
        string|int|float|Decimal $withdraw,
        string|int|float|Decimal $real_commitment,
        string|int|float|Decimal $commitment_profit,
        string|int|float|Decimal $profit
    ): StatementFutures
    {
        return StatementFutures::create([
            StatementFutures::GROUP => $group,
            StatementFutures::PERIOD => $period,
            StatementFutures::COMMITMENT => $commitment,
            StatementFutures::OPEN_PROFIT => $openProfit,
            StatementFutures::CLOSE_PROFIT => $closeProfit,
            StatementFutures::DEPOSIT => $deposit,
            StatementFutures::WITHDRAW => $withdraw,
            StatementFutures::REAL_COMMITMENT => $real_commitment,
            StatementFutures::COMMITMENT_PROFIT => $commitment_profit,
            StatementFutures::PROFIT => $profit
        ]);
    }

    public function fetchFuturesProfit(Carbon $period): Decimal
    {
        return Decimal::make(0)->add(
            ...StatementFutures::where(StatementFutures::PERIOD, $period->format('Ym'))
            ->get()
            ->pluck(StatementFutures::PROFIT)
            ->toArray()
        );
    }
}
