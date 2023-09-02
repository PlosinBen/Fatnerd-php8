<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\Models\InvestAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static InvestAccountRepository make()
 */
class InvestAccountRepository extends Repository
{
    public function fetch(array $filter): Collection
    {
        return InvestAccount::orderBy(InvestAccount::ID)->get();
    }

    public function fetchList()
    {
        return InvestAccount::orderBy(InvestAccount::ID)->paginate(20);
    }

    public function insert(string $alias, Carbon $startPeriod): InvestAccount
    {
        return InvestAccount::create([
            InvestAccount::ALIAS => $alias,
            InvestAccount::START_PERIOD => $startPeriod
        ]);
    }
}
