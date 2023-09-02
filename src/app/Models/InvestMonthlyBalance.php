<?php

namespace App\Models;

use App\Contracts\ModelDecimalAttributeTrait;
use App\Contracts\ModelPeriodTrait;
use App\lib\Decimal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $invest_account_id
 * @property Carbon $period
 * @property Decimal $deposit
 * @property Decimal $transfer
 * @property Decimal $withdraw
 * @property Decimal $commitment
 * @property int $weight
 * @property Decimal $profit
 * @property Decimal $expense
 * @property Decimal $balance
 */
class InvestMonthlyBalance extends Model
{
    use ModelPeriodTrait;
    use ModelDecimalAttributeTrait;

    const INVEST_ACCOUNT_ID = 'invest_account_id';

    const PERIOD = 'period';

    const DEPOSIT = 'deposit';

    const TRANSFER = 'transfer';

    const WITHDRAW = 'withdraw';

    const COMMITMENT = 'commitment';

    const WEIGHT = 'weight';

    const PROFIT = 'profit';

    const EXPENSE = 'expense';

    const BALANCE = 'balance';

    protected $table = 'invest_monthly_balance';

    protected $guarded = [];

    protected function deposit(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function transfer(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function withdraw(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function profit(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function expense(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function balance(): Attribute
    {
        return $this->decimalAttribute();
    }
}
