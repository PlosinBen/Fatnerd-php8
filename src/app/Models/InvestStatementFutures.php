<?php

namespace App\Models;

use App\Contracts\ModelPeriodTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $group
 * @property-read Carbon $period
 * @property-read numeric $commitment
 * @property-read numeric $open_profit
 * @property-read numeric $write_off_profit
 * @property-read numeric $deposit
 * @property-read numeric $withdraw
 * @property-read numeric $real_commitment
 * @property-read numeric $commitment_profit
 * @property-read numeric $profit
 */
class InvestStatementFutures extends Model
{
    use ModelPeriodTrait;

    const ID = 'id';

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
