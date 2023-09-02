<?php

namespace App\Models;

use App\Contracts\ModelDecimalAttributeTrait;
use App\Contracts\ModelPeriodTrait;
use App\Contracts\ModelYearMonthAttributeTrait;
use App\lib\Decimal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 *
 * @property int $invest_account_id
 * @property Carbon $statement_period
 * @property Decimal $commitment
 * @property int $weight
 * @property Decimal $profit
 */
class StatementDistribute extends Model
{
    use ModelYearMonthAttributeTrait, ModelDecimalAttributeTrait;

    const ID = 'id';

    const STATEMENT_PERIOD = 'statement_period';

    const INVEST_ACCOUNT_ID = 'invest_account_id';

    const COMMITMENT = 'commitment';

    const WEIGHT = 'weight';

    const PROFIT = 'profit';

    protected $table = 'statement_distribute';

    protected function commitment(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function profit(): Attribute
    {
        return $this->decimalAttribute();
    }
}
