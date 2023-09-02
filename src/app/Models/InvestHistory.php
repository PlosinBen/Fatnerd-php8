<?php

namespace App\Models;

use App\Contracts\ModelDecimalAttributeTrait;
use App\lib\Decimal;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $invest_account_id
 *
 * @property $deal_at
 * @property int $increment
 * @property string $type
 * @property Decimal $amount
 * @property Decimal $balance
 * @property string $note
 */
class InvestHistory extends Model
{
    use ModelDecimalAttributeTrait;

    const ID = 'id';

    const INVEST_ACCOUNT_ID = 'invest_account_id';

    const DEAL_AT = 'deal_at';

    const INCREMENT = 'increment';

    const TYPE = 'type';

    const AMOUNT = 'amount';

    const BALANCE = 'balance';

    const NOTE = 'note';

    protected $table = 'invest_history';

    protected $guarded = [];

    protected function amount(): Attribute
    {
        return $this->decimalAttribute();
    }

    protected function balance(): Attribute
    {
        return $this->decimalAttribute();
    }
}
