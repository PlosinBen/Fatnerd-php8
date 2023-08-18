<?php

namespace App\Service;

use App\Models\InvestStatementFutures;
use App\Repository\InvestStatementFuturesRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class StatementService
{
    public function getFuturesList(): LengthAwarePaginator
    {
        $investStatementFuturesRepository = InvestStatementFuturesRepository::make();

        return $investStatementFuturesRepository->fetchList();
    }

    /**
     * @param string $group
     * @param Carbon $period
     * @param int|float $commitment
     * @param int|float $openProfit
     * @param int|float $writeOffProfit
     * @param int|float $deposit
     * @param int|float $withdraw
     * @return InvestStatementFutures
     */
    public function createFutures(string $group, Carbon $period, int|float $commitment, int|float $openProfit, int|float $writeOffProfit, int|float $deposit, int|float $withdraw)
    {
        $investStatementFuturesRepository = InvestStatementFuturesRepository::make();

        return $investStatementFuturesRepository->insert(
            $group,
            $period,
            $commitment,
            $openProfit,
            $writeOffProfit,
            $deposit,
            $withdraw
        );
    }
}
