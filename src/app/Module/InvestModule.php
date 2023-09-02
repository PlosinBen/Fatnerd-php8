<?php

namespace App\Module;

use App\Contracts\InstanceTrait;
use App\DataMapper\CalculateMonthlyBalance;
use App\lib\Decimal;
use App\Models\InvestHistory;
use App\Models\InvestMonthlyBalance;
use App\Repository\InvestHistoryRepository;
use App\Repository\InvestMonthlyBalanceRepository;
use Carbon\Carbon;

class InvestModule
{
    use InstanceTrait;

    public function addHistory(int $investAccount, Carbon $dealAt, string $type, Decimal $amount, string $note = null): self
    {
        if ($type === 'transfer') {
            # 出金轉存 = B出金轉存 + user出金
            $this->addHistory(
                1,
                $dealAt,
                $type,
                $amount,
                "from " . optional($investAccount)->id ?? $investAccount
            );

            $type = 'withdraw';
        }

        InvestHistoryRepository::make()->create(
            $investAccount,
            $dealAt->toDateString(),
            $type,
            $amount->mul(config("invest.symbol.{$type}", 1))->get(),
            $note
        );

        return $this;
    }

    public function getAccountLastBalance(int $investAccount, Carbon $dealAt = null): Decimal
    {
        return InvestHistoryRepository::make()
            ->fetchAccountLastBalance($investAccount, $dealAt->toDateString());
    }

    /**
     * 重新計算history數值
     * @param int $investAccount
     * @param Carbon $dealAt
     * @return void
     */
    public function calcHistoryBalance(int $investAccount, Carbon $dealAt): self
    {
        # 重新計算balance數值
        $balance = $this->getAccountLastBalance($investAccount, $dealAt);

        InvestHistoryRepository::make()->fetchByAccountIdDealDate($investAccount, $dealAt)
            ->sortBy(fn(InvestHistory $investHistory) => match ($investHistory->type) {
                'profit' => 100,
                'expense' => 200,
                default => 1,
            }, SORT_NUMERIC)
            ->each(function (InvestHistory $investHistory, $index) use (&$balance) {
                $balance = $balance->add(
                    $investHistory->amount
                        ->mul(
                            config("invest.symbol.{$investHistory->type}")
                        )
                );

                InvestHistoryRepository::make()->updateIncrementBalance($investHistory, $index, $balance->get());
            });

        return $this;
    }

    public function getMonthlyBalanceRecord(int $investAccount, Carbon $period): ?InvestMonthlyBalance
    {
        return InvestMonthlyBalanceRepository::make()->fetch($investAccount, $period->format('Ym'));
    }

    public function createMonthlyBalanceRecord(int $investAccount, Carbon $period): InvestMonthlyBalance
    {
        return InvestMonthlyBalanceRepository::make()->create(
            investAccountId: $investAccount,
            period: $period->format('Ym')
        );
    }

    /**
     * 計算month balance數值
     * @param int $investAccount
     * @param Carbon $period
     * @return \App\Models\InvestMonthlyBalance
     */
    public function calcMonthBalance(int $investAccount, Carbon $period): self
    {
        $calculateMonthlyBalance = CalculateMonthlyBalance::make(
            optional($this->getMonthlyBalanceRecord(
                $investAccount,
                $period->copy()->firstOfMonth()->subMonth()
            ))->balance ?? Decimal::make()
        );

        InvestHistoryRepository::make()->fetchDealBetween(
            $investAccount,
            $period->copy()->startOfMonth(),
            $period->copy()->endOfMonth()
        )->each(fn(InvestHistory $investHistory) => $calculateMonthlyBalance->pushHistory($investHistory));

        InvestMonthlyBalanceRepository::make()->create(
            investAccountId: $investAccount,
            period: $period->format('Ym'),
            deposit: $calculateMonthlyBalance->deposit,
            transfer: $calculateMonthlyBalance->transfer,
            withdraw: $calculateMonthlyBalance->withdraw,
//            commitment: $commitment,
//            weight: $commitment->div(5000)->floor(),
            profit: $calculateMonthlyBalance->profit,
            expense: $calculateMonthlyBalance->expense,
            balance: $calculateMonthlyBalance->balance()
        );

        return $this;
    }
}
