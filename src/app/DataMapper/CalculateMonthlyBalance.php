<?php

namespace App\DataMapper;

use App\lib\Decimal;
use App\Models\InvestHistory;

/**
 * @property-read Decimal $deposit
 * @property-read Decimal $transfer
 * @property-read Decimal $withdraw
 * @property-read Decimal $profit
 * @property-read Decimal $expense
 * @property-read Decimal $preBalance
 */
class CalculateMonthlyBalance
{
    protected Decimal $deposit;

    protected Decimal $transfer;

    protected Decimal $withdraw;

    protected Decimal $profit;

    protected Decimal $expense;

    protected Decimal $preBalance;

    public function __get($name)
    {
        return $this->{$name};
    }

    public static function make(int|float|Decimal $preBalance = 0): CalculateMonthlyBalance
    {
        return app()->make(static::class, [
            'preBalance' => $preBalance
        ]);
    }

    public function __construct(int|float|Decimal $preBalance)
    {
        $emptyDecimal = Decimal::make(0);

        $this->deposit = clone $emptyDecimal;
        $this->transfer = clone $emptyDecimal;
        $this->withdraw = clone $emptyDecimal;
        $this->profit = clone $emptyDecimal;
        $this->expense = clone $emptyDecimal;

        $this->preBalance = $preBalance;
    }

    public function pushHistory(InvestHistory $investHistory): self
    {
        $this->{$investHistory->type} = $this->{$investHistory->type}->add($investHistory->amount);

        return $this;
    }

    public function balance()
    {
        return $this->preBalance
            ->add(
                $this->deposit,
                $this->transfer,
                $this->profit,
                $this->expense
            )
            ->sub(
                $this->withdraw
            );
    }
}
