<?php

namespace App\Service;

use App\Contracts\InstanceTrait;
use App\Models\InvestAccount;
use App\Repository\InvestAccountRepository;
use App\Repository\InvestHistoryRepository;
use Illuminate\Database\Eloquent\Collection;

class InvestService
{
    public function getAccounts(array $filter): Collection
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
}
