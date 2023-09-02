<?php

namespace App\DataMapper;

use App\lib\Decimal;
use App\Models\InvestAccount;

class DistributeProfit
{
    public readonly InvestAccount $account;

    public readonly int $account_id;

    public readonly Decimal $balance;

    public static function make(InvestAccount $investAccount): DistributeProfit
    {
        return app()->make(static::class, ['investAccount' => $investAccount]);
    }

    public function __construct(InvestAccount $investAccount)
    {
        $this->account = $investAccount;
        $this->account_id = $investAccount->id;
    }

    public function setBalance(Decimal $num): self
    {
        $this->balance = $num;
        return $this;
    }
}
