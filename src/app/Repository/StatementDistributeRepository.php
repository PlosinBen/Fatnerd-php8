<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\lib\Decimal;
use App\Models\StatementDistribute;
use Carbon\Carbon;

class StatementDistributeRepository extends Repository
{
    public function create(Carbon $statementPeriod, int $investAccountId, int|float|Decimal $commitment, int|Decimal $weight): StatementDistribute
    {
        return StatementDistribute::updateOrCreate([
            StatementDistribute::STATEMENT_PERIOD => $statementPeriod,
            StatementDistribute::INVEST_ACCOUNT_ID => $investAccountId
        ], [
            StatementDistribute::COMMITMENT => $commitment,
            StatementDistribute::WEIGHT => $weight
        ]);
    }

    public function update(
        string $statementPeriod,
        int    $investAccountId,
        string $commitment = null,
        string $weight = null,
        string $profit = null
    ): StatementDistribute
    {
        return StatementDistribute::updateOrCreate([
            StatementDistribute::STATEMENT_PERIOD => $statementPeriod,
            StatementDistribute::INVEST_ACCOUNT_ID => $investAccountId
        ], array_filter([
            StatementDistribute::COMMITMENT => $commitment,
            StatementDistribute::WEIGHT => $weight,
            StatementDistribute::PROFIT => $profit
        ]));
    }

    public function updateProfit(StatementDistribute $statementDistribute, Decimal $profit): StatementDistribute
    {
        $statementDistribute->profit = $profit;

        $statementDistribute->save();

        return $statementDistribute;
    }

    public function delete(string $statementPeriod, int $investAccountId)
    {
        return StatementDistribute::where(StatementDistribute::STATEMENT_PERIOD, $statementPeriod)
            ->where(StatementDistribute::INVEST_ACCOUNT_ID, $investAccountId)
            ->delete();
    }

    public function deleteByPeriod(string $period)
    {
        return StatementDistribute::where(StatementDistribute::STATEMENT_PERIOD, $period)->delete();
    }
}
