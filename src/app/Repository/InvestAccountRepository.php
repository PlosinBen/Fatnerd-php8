<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\Models\InvestAccount;

/**
 * @method static InvestAccountRepository make()
 */
class InvestAccountRepository extends Repository
{
    public function fetchList()
    {
        return InvestAccount::orderBy(InvestAccount::ID)->paginate(20);
    }

    public function insert(string $alias): InvestAccount
    {
        return InvestAccount::create([
            InvestAccount::ALIAS => $alias
        ]);
    }
}
