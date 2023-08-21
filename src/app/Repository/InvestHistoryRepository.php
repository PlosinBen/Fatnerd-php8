<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\Models\InvestHistory;
use Illuminate\Pagination\LengthAwarePaginator;

class InvestHistoryRepository extends Repository
{
    public function fetch(array $filter): LengthAwarePaginator
    {
        return InvestHistory::orderBy(InvestHistory::ID)->paginate(20);
    }
}
