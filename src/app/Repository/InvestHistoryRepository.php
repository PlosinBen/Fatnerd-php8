<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Models\InvestHistory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class InvestHistoryRepository extends Repository
{
    public function fetch(array $filter): LengthAwarePaginator
    {
        return InvestHistory::orderBy(InvestHistory::ID)->paginate(20);
    }

    public function fetchByAccountIdDealDate(int $accountId, Carbon $dealAt): Collection
    {
        return InvestHistory::where(InvestHistory::INVEST_ACCOUNT_ID, $accountId)
            ->where(InvestHistory::DEAL_AT, $dealAt->toDateString())
            ->get();
    }

    public function updateIncrement(int $id, int $increment)
    {
        InvestHistory::where(InvestHistory::ID, $id)->update([
            InvestHistory::INCREMENT => $increment
        ]);
    }

    public function create(
        InvestAccount|int        $investAccount,
        Carbon                   $dealAt,
        string                   $type,
        float|Decimal|int|string $amount,
        string                   $note
    ): InvestHistory
    {
        return InvestHistory::create([
            InvestHistory::INVEST_ACCOUNT_ID => $investAccount instanceof InvestAccount ? $investAccount->id : $investAccount,
            InvestHistory::DEAL_AT => $dealAt->toDateString(),
            InvestHistory::TYPE => $type,
            InvestHistory::AMOUNT => $amount,
            InvestHistory::NOTE => $note
        ]);
    }
}
