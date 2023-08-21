<?php

namespace App\Service;

use App\Contracts\InstanceTrait;
use App\Models\Statement;
use App\Repository\StatementAssetRepository;
use App\Repository\StatementRepository;
use Carbon\Carbon;

class StatementService
{
    use InstanceTrait;

    public function getList()
    {
        return StatementRepository::make()->fetch();
    }

    public function refresh(Carbon $period): Statement
    {
        return StatementRepository::make()->update(
            $period,
            0,
            0,
            StatementAssetRepository::make()->fetchProfit($period)
        );
    }
}
