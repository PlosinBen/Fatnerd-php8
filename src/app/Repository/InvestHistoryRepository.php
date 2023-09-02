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

    public function fetchByAccountIdAfterDate(int $accountId, Carbon $dealAt): Collection
    {
        return InvestHistory::where(InvestHistory::INVEST_ACCOUNT_ID, $accountId)
            ->where(InvestHistory::DEAL_AT, '>=', $dealAt->toDateString())
            ->orderBy(InvestHistory::DEAL_AT, 'ASC')
            ->orderBy(InvestHistory::INCREMENT, 'ASC')
            ->get();
    }

    public function fetchDealBetween(int $accountId, Carbon $startAt, Carbon $endAt): Collection
    {
        return InvestHistory::where(InvestHistory::INVEST_ACCOUNT_ID, $accountId)
            ->whereBetween(InvestHistory::DEAL_AT, [$startAt, $endAt])
            ->get();
    }

    public function fetchAccountLastBalance(int $accountId, string $date): Decimal
    {
        $entity = InvestHistory::where(InvestHistory::INVEST_ACCOUNT_ID, $accountId)
            ->where(InvestHistory::DEAL_AT, '<', $date)
            ->orderBy(InvestHistory::DEAL_AT, 'DESC')
            ->first();

        return Decimal::make(
            optional($entity)->balance
        );
    }

    public function updateIncrement(InvestHistory $entity, int $increment)
    {
        $entity->update([
            InvestHistory::INCREMENT => $increment
        ]);

//        InvestHistory::where(InvestHistory::ID, $id)->update([
//            InvestHistory::INCREMENT => $increment
//        ]);
    }

    public function updateIncrementBalance(InvestHistory $entity, int $increment, string $balance)
    {
        $entity->update([
            InvestHistory::INCREMENT => $increment,
            InvestHistory::BALANCE => $balance
        ]);
    }

    public function updateBalance(InvestHistory $entity, Decimal $balance)
    {
        $entity->update([
            InvestHistory::BALANCE => $balance
        ]);
    }

    public function create(
        int    $investAccount,
        string $dealAt,
        string $type,
        string $amount,
        string $note
    ): InvestHistory
    {
        return InvestHistory::create([
            InvestHistory::INVEST_ACCOUNT_ID => $investAccount,
            InvestHistory::DEAL_AT => $dealAt,
            InvestHistory::TYPE => $type,
            InvestHistory::AMOUNT => $amount,
            InvestHistory::NOTE => $note
        ]);
    }
}
