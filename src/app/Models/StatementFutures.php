<?php

namespace App\Models;

use App\Contracts\ModelDecimalAttributeTrait;
use App\Contracts\ModelPeriodTrait;
use App\lib\Decimal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $group
 * @property Carbon $period
 * @property Decimal $commitment
 * @property Decimal $open_profit
 * @property Decimal $close_profit
 * @property Decimal $deposit
 * @property Decimal $withdraw
 * @property Decimal $real_commitment
 * @property Decimal $commitment_profit
 * @property Decimal $profit
 */
class StatementFutures extends Model
{
    use ModelPeriodTrait, ModelDecimalAttributeTrait;

    const ID = 'id';

    const GROUP = 'group';

    const PERIOD = 'period';

    const COMMITMENT = 'commitment';

    const OPEN_PROFIT = 'open_profit';

    const CLOSE_PROFIT = 'close_profit';

    const DEPOSIT = 'deposit';

    const WITHDRAW = 'withdraw';

    const REAL_COMMITMENT = 'real_commitment';

    const COMMITMENT_PROFIT = 'commitment_profit';

    const PROFIT = 'profit';

    protected $table = 'statement_futures';

    protected $guarded = [];

    protected $casts = [
        'commitment' => 'string',
        'open_profit' => 'string',
        'close_profit' => 'string',
        'deposit' => 'string',
        'withdraw' => 'string',
        'real_commitment' => 'string',
        'commitment_profit' => 'string',
        'profit' => 'string',
    ];

    protected function commitment(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function openProfit(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function closeProfit(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function deposit(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function withdraw(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function realCommitment(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function commitmentProfit(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function profit(): Attribute
    {
        return $this->decimalAttribute();
    }
}
