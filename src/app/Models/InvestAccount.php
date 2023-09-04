<?php

namespace App\Models;

use App\Contracts\ModelYearMonthAttributeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $alias
 * @property string $start_period
 * @property Carbon $start_period_carbon
 * @property string|null $end_period
 * @property Carbon|null $end_period_carbon
 */
class InvestAccount extends Model
{
    use ModelYearMonthAttributeTrait;

    const ID = 'id';

    const USER_ID = 'user_id';

    const ALIAS = 'alias';

    const START_PERIOD = 'start_period';

    const END_PERIOD = 'end_period';

    protected $table = 'invest_account';

    protected $fillable = [
        'user_id',
        'alias'
    ];

    protected function start_period(): Attribute
    {
        return $this->yearMonthAttribute();
    }

    protected function startPeriodCarbon(): Attribute
    {
        return Attribute::make(
            get: fn($period, array $attributes) => Carbon::createFromFormat('Ym', $attributes[self::START_PERIOD]),
        );
    }

    protected function end_period(): Attribute
    {
        return $this->yearMonthAttribute();
    }

    protected function endPeriodCarbon(): Attribute
    {
        return Attribute::make(
            get: function ($period, array $attributes) {
                if ($attributes[self::END_PERIOD] === null) {
                    return null;
                }

                return Carbon::createFromFormat('Ym', $attributes[self::END_PERIOD]);
            },
        );
    }

    public function investMonthBalance(): HasMany
    {
        return $this->hasMany(InvestMonthlyBalance::class);
    }

    /** Relations */

    public function investMonthlyBalance(): HasMany
    {
        return $this->hasMany(InvestMonthlyBalance::class, InvestMonthlyBalance::INVEST_ACCOUNT_ID, self::ID);
    }
}
