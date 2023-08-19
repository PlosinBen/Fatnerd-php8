<?php

namespace App\Models;

use App\Contracts\ModelPeriodTrait;
use Illuminate\Database\Eloquent\Model;

class StatementAsset extends Model
{
    use ModelPeriodTrait;

    const PERIOD = 'period';

    const ASSET_TYPE = 'asset_type';

    const BASE_PROFIT = 'base_profit';

    const PROFIT = 'profit';

    protected $table = 'statement_asset';
}
