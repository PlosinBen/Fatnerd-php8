<?php

namespace App\DataCalculator;

use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Models\InvestMonthlyBalance;
use Carbon\Carbon;

/**
 * @property-read InvestAccount $account
 * @property-read Decimal $commitment
 * @property-read Decimal $weight
 * @property-read Decimal $profit
 */
class StatementProfitDistributeCalculator
{

    protected Carbon $period;

    protected InvestAccount $account;

    protected InvestMonthlyBalance $monthlyBalance;

    protected Decimal $commitment;

    protected Decimal $weight;

    protected Decimal $profit;

    public static function make(Carbon $period, InvestAccount $account): ?StatementProfitDistributeCalculator
    {
        if (!$period->isBetween($account->start_period_carbon, $account->end_period_carbon)) {
            return null;
        }

        return app()->make(static::class, [
            'period' => $period,
            'account' => $account
        ]);
    }

    public function __construct(Carbon $period, InvestAccount $account)
    {
        $this->period = $period;
        $this->account = $account;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function setMonthBalance(InvestMonthlyBalance $investMonthlyBalance): ?self
    {
        $this->monthlyBalance = $investMonthlyBalance;

        /**
         * 可分配權益: 上期結餘+出金+出金轉存
         * 可分配權益: 當期結餘-入金-損益-費用
         */
        $this->commitment = $this->monthlyBalance->balance
            ->sub($this->monthlyBalance->deposit)
            ->sub($this->monthlyBalance->profit)
            ->add($this->monthlyBalance->expense);

        if (!$this->commitment->moreThan(0)) {
            return null;
        }

        $this->weight = $this->commitment->div(5000)->floor()->max(0.5);

        return $this;
    }

    public function setProfitPerWeight(Decimal $profitPerWeight): self
    {
        $this->profit = $profitPerWeight->mul($this->weight)->floor();

        return $this;
    }

    public function replenishAdminProfit(Decimal $profit): self
    {
        $this->profit = $this->profit->add($profit);

        return $this;
    }
}
