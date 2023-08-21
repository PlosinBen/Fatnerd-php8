<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestHistory extends Model
{
    const ID = 'id';

    const INVEST_ACCOUNT_ID = 'invest_account_id';

    const DEAL_AT = 'deal_at';

    const INCREMENT = 'increment';

    const TYPE = 'type';

    const AMOUNT = 'amount';

    const BALANCE = 'balance';

    protected $table = 'invest_history';
}
