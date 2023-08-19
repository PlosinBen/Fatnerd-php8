<?php

namespace App\Service\Statement;

use App\Contracts\InstanceTrait;
use App\lib\Decimal;
use App\Models\StatementAsset;
use App\Repository\StatementAssetRepository;
use App\Service\StatementService;
use Carbon\Carbon;

class AssetService
{
    use InstanceTrait;

    public function create(Carbon $period, string $asset, string|int|float|Decimal $baseProfit): StatementAsset
    {
        $entity = StatementAssetRepository::make()
            ->create($period, $asset, $baseProfit, $baseProfit);

        StatementService::make()->refresh($period);

        return $entity;
    }
}
