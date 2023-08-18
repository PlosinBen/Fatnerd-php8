<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\Models\InvestStatementFutures;
use Carbon\Carbon;

/**
 * @method static InvestStatementFuturesRepository make()
 */
class InvestStatementFuturesRepository extends Repository
{
    public function fetchList()
    {
        return InvestStatementFutures::orderBy(InvestStatementFutures::PERIOD, 'DESC')->paginate(20);
    }

    public function insert(string $group, Carbon $period, int|float $commitment, int|float $openProfit, int|float $writeOffProfit, int|float $deposit, int|float $withdraw)
    {
        return InvestStatementFutures::create([
            InvestStatementFutures::GROUP => $group,
            InvestStatementFutures::PERIOD => $period,
            InvestStatementFutures::COMMITMENT => $commitment,
            InvestStatementFutures::OPEN_PROFIT => $openProfit,
            InvestStatementFutures::WRITE_OFF_PROFIT => $writeOffProfit,
            InvestStatementFutures::DEPOSIT => $deposit,
            InvestStatementFutures::WITHDRAW => $withdraw,
        ]);
    }
}
