<?php

namespace App\Service;

use App\Contracts\InstanceTrait;
use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Models\InvestHistory;
use App\Repository\InvestAccountRepository;
use App\Repository\InvestHistoryRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class InvestService
{
    use InstanceTrait;

    public function getAccounts(array $filter = []): Collection
    {
        return InvestAccountRepository::make()->fetch($filter);
    }

    public function getPagingAccounts()
    {
        return InvestAccountRepository::make()->fetchList();
    }

    public function getAccountList()
    {
        $investAccountRepository = InvestAccountRepository::make();

        return $investAccountRepository->fetchList();
    }

    public function createAccount(string $alias): InvestAccount
    {
        $investAccountRepository = InvestAccountRepository::make();

        return $investAccountRepository->insert($alias);
    }

    public function getHistoryList(array $filter)
    {
        return InvestHistoryRepository::make()->fetch($filter);
    }

    public function addHistory(InvestAccount|int $investAccount, Carbon $dealAt, string $type, float|int|string|Decimal $amount, ?string $note): InvestHistory
    {
        $entity = InvestHistoryRepository::make()->create(
            $investAccount,
            $dealAt,
            $type,
            $amount,
            $note ?? ''
        );

        $this->resetHistoryIncrement($entity->invest_account_id, $dealAt);

        return $entity->refresh();
    }

    public function resetHistoryIncrement(int $investAccount, Carbon $dealAt)
    {
        $investHistoryRepository = InvestHistoryRepository::make();

        $investHistoryRepository->fetchByAccountIdDealDate($investAccount, $dealAt)
            ->sortBy(function (InvestHistory $investHistory) {
                return match ($investHistory->type) {
                    'profit' => 100,
                    'expense' => 200,
                    default => 1,
                };
            }, SORT_NUMERIC)
            ->values()
            ->each(
                fn(InvestHistory $investHistory, $index) => $investHistoryRepository->updateIncrement($investHistory->id, $index)
            );
    }
}
