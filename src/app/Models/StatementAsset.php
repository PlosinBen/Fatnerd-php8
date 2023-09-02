<?php

namespace App\Models;

use App\Contracts\ModelPeriodTrait;
use App\lib\Decimal;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $period
 * @property string $asset_type
 * @property Decimal $profit
 */
class StatementAsset extends Model
{
    use ModelPeriodTrait;

    const PERIOD = 'period';

    const ASSET_TYPE = 'asset_type';

    const BASE_PROFIT = 'base_profit';

    const PROFIT = 'profit';

    protected $table = 'statement_asset';
}
