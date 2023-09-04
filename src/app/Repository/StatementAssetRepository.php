<?php

namespace App\Repository;

use App\Contracts\Repository;
use App\lib\Decimal;
use App\Models\StatementAsset;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class StatementAssetRepository extends Repository
{
    public function create(
        Carbon                   $period,
        string                   $assetType,
        string|int|float|Decimal $baseProfit,
        string|int|float|Decimal $profit
    ): StatementAsset
    {
        return StatementAsset::firstOrCreate([
            StatementAsset::PERIOD => $period->format('Ym'),
            StatementAsset::ASSET_TYPE => $assetType
        ], [
            StatementAsset::BASE_PROFIT => $baseProfit,
            StatementAsset::PROFIT => $profit
        ]);
    }

    public function fetchByPeriod(string $period): Collection
    {
        return StatementAsset::where(StatementAsset::PERIOD, $period)
            ->get();
    }

    public function fetchProfit(Carbon $period): Decimal
    {
        return Decimal::make(0)->add(
            ...
            StatementAsset::where(StatementAsset::PERIOD, $period->format('Ym'))
                ->get()
                ->pluck(StatementAsset::PROFIT)
        );
    }
}
