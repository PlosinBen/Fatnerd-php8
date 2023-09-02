<?php

namespace App\Service;

use App\Contracts\InstanceTrait;
use App\DataMapper\CalculateMonthlyBalance;
use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Models\InvestHistory;
use App\Models\InvestMonthlyBalance;
use App\Module\InvestModule;
use App\Repository\InvestAccountRepository;
use App\Repository\InvestHistoryRepository;
use App\Repository\InvestMonthlyBalanceRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class InvestService
{
    use InstanceTrait;

    public function getAccounts(array $filter = []): Collection
    {
        return InvestAccountRepository::make()->fetch($filter);
    }

    public function getAccountLastBalance(InvestAccount|int $investAccount, Carbon $dealAt = null): Decimal
    {
        return InvestHistoryRepository::make()->fetchAccountLastBalance(
            optional($investAccount)->id ?? $investAccount, $dealAt
        );
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

        return $investAccountRepository->insert($alias, Carbon::now());
    }

    public function getHistoryList(array $filter)
    {
        return InvestHistoryRepository::make()->fetch($filter);
    }

    public function addHistory(
        InvestAccount|int        $investAccount,
        Carbon                   $dealAt,
        string                   $type,
        float|int|string|Decimal $amount,
        string                   $note = '')
    {
        $accountId = optional($investAccount)->id ?? $investAccount;

        InvestModule::make()
            ->addHistory(
                $accountId,
                $dealAt,
                $type,
                Decimal::make($amount),
                $note
            )
            ->calcHistoryBalance($accountId, $dealAt)
            ->calcMonthBalance($accountId, $dealAt);
    }

    public function calcMonthBalance(InvestAccount|int $investAccount, Carbon $period): self
    {
        $accountId = optional($investAccount)->id ?? $investAccount;

        InvestModule::make()->calcMonthBalance($accountId, $period);

        return $this;
    }

    public function getMonthlyBalance(InvestAccount|int $investAccount, Carbon $period)
    {
        $accountId = optional($investAccount)->id ?? $investAccount;

        $entity = InvestModule::make()->getMonthlyBalanceRecord($accountId, $period);

        if ($entity === null) {
            $entity = InvestModule::make()
                ->calcMonthBalance($accountId, $period)
                ->getMonthlyBalanceRecord($accountId, $period);
        }

        return $entity;
    }
}
