<?php

namespace App\Models;

use App\Contracts\ModelPeriodTrait;
use Illuminate\Database\Eloquent\Model;

class InvestStatementFutures extends Model
{
    use ModelPeriodTrait;

    const GROUP = 'group';

    const PERIOD = 'period';

    const COMMITMENT = 'commitment';

    const OPEN_PROFIT = 'open_profit';

    const WRITE_OFF_PROFIT = 'write_off_profit';

    const DEPOSIT = 'deposit';

    const WITHDRAW = 'withdraw';

    const REAL_COMMITMENT = 'real_commitment';

    const COMMITMENT_PROFIT = 'commitment_profit';

    const PROFIT = 'profit';

    protected $table = 'invest_statement_futures';

    protected $guarded = [];
}
