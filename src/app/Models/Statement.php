<?php

namespace App\Models;

use App\Contracts\ModelDecimalAttributeTrait;
use App\Contracts\ModelPeriodTrait;
use App\lib\Decimal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon $period
 * @property Decimal $commitment
 * @property int $weight
 * @property Decimal $profit
 * @property Decimal $profit_per_weight
 * @property Carbon $distribute_at
 */
class Statement extends Model
{
    use ModelPeriodTrait, ModelDecimalAttributeTrait;

    const PERIOD = 'period';

    const COMMITMENT = 'commitment';

    const WEIGHT = 'weight';

    const PROFIT = 'profit';

    const PROFIT_PER_WEIGHT = 'profit_per_weight';

    const DISTRIBUTE_AT = 'distribute_at';

    protected $table = 'statement';

    protected $primaryKey = 'period';

    public $incrementing = false;

    protected function commitment()
    {
        return $this->decimalAttribute();
    }

    protected function profit()
    {
        return $this->decimalAttribute();
    }

    protected function profitPerWeight()
    {
        return $this->decimalAttribute();
    }
}
