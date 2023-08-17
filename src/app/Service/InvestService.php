<?php

namespace App\Service;

use App\Contracts\InstanceTrait;
use App\Models\InvestAccount;
use App\Repository\InvestAccountRepository;

class InvestService
{
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
}
