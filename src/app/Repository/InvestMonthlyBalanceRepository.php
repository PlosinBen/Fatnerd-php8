<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\Models\InvestMonthlyBalance;
use Illuminate\Database\Eloquent\Collection;

class InvestMonthlyBalanceRepository extends Repository
{
    public function fetch(int $investAccountId, string $period): ?InvestMonthlyBalance
    {
        return InvestMonthlyBalance::where(InvestMonthlyBalance::INVEST_ACCOUNT_ID, $investAccountId)
            ->where(InvestMonthlyBalance::PERIOD, $period)
            ->first();
    }

    public function create(
        int    $investAccountId,
        string $period,
        string $deposit = null,
        string $transfer = null,
        string $withdraw = null,
//        string $commitment = null,
//        string $weight = null,
        string $profit = null,
        string $expense = null,
        string $balance = null
    ): InvestMonthlyBalance
    {
        return InvestMonthlyBalance::updateOrCreate([
            InvestMonthlyBalance::INVEST_ACCOUNT_ID => $investAccountId,
            InvestMonthlyBalance::PERIOD => $period
        ], array_filter([
            InvestMonthlyBalance::DEPOSIT => $deposit,
            InvestMonthlyBalance::TRANSFER => $transfer,
            InvestMonthlyBalance::WITHDRAW => $withdraw,
//            InvestMonthlyBalance::COMMITMENT => $commitment,
//            InvestMonthlyBalance::WEIGHT => $weight,
            InvestMonthlyBalance::PROFIT => $profit,
            InvestMonthlyBalance::EXPENSE => $expense,
            InvestMonthlyBalance::BALANCE => $balance
        ]));
    }

    public function fetchByPeriod(string $period): Collection
    {
        return InvestMonthlyBalance::where(InvestMonthlyBalance::PERIOD, $period)->get();
    }

    public function fetchLast(int $accountId, string $period)
    {
        return InvestMonthlyBalance::where(InvestMonthlyBalance::INVEST_ACCOUNT_ID, $accountId)
            ->where(InvestMonthlyBalance::PERIOD, '<=', $period)
            ->orderBy(InvestMonthlyBalance::PERIOD, 'DESC')
            ->first();
    }
}
