<?php

namespace App\Service;

use App\Contracts\InstanceTrait;
use App\DataCalculator\CalculateMonthlyBalance;
use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Models\InvestHistory;
use App\Models\InvestMonthlyBalance;
use App\Repository\InvestAccountRepository;
use App\Repository\InvestHistoryRepository;
use App\Repository\InvestMonthlyBalanceRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class InvestService
{
    use InstanceTrait;

    public function getAccounts(array $filter = []): Collection
    {
        return InvestAccountRepository::make()->fetch($filter);
    }

    public function getAccountLastBalance(InvestAccount|int $investAccount, Carbon $dealAt = null): Decimal
    {
        return InvestHistoryRepository::make()->fetchAccountLastBalance(
            optional($investAccount)->id ?? $investAccount, $dealAt
        );
    }

    public function getPagingAccounts()
    {
        return InvestAccountRepository::make()->fetchList();
    }

    public function getAccountList()
    {
        $investAccountRepository = InvestAccountRepository::make();

        return $investAccountRepository->fetchList();
    }

    public function createAccount(string $alias): InvestAccount
    {
        $investAccountRepository = InvestAccountRepository::make();

        return $investAccountRepository->insert($alias, Carbon::now());
    }

    public function getHistoryList(array $filter)
    {
        return InvestHistoryRepository::make()->fetch($filter);
    }

    public function addHistory(
        InvestAccount|int        $investAccount,
        Carbon                   $dealAt,
        string                   $type,
        float|int|string|Decimal $amount,
        string                   $note = ''): self
    {
        $amount = Decimal::make($amount);
        $accountId = optional($investAccount)->id ?? $investAccount;

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

        $this->syncMonthlyBalance($accountId, $dealAt);

        return $this;
    }

    public function getMonthlyBalanceByPeriod(Carbon $period)
    {
        return InvestMonthlyBalanceRepository::make()
            ->fetchByPeriod($period->copy()->firstOfMonth()->subMonth()->format('Ym'))
            ->filter(fn(InvestMonthlyBalance $monthlyBalance) => $monthlyBalance->balance->moreThan(0))
            ->map(function (InvestMonthlyBalance $monthlyBalance) use ($period) {
                $entity = $this->getMonthlyBalanceRecord($monthlyBalance->invest_account_id, $period);

                if ($entity === null) {
                    $entity = $this->syncMonthlyBalance($monthlyBalance->invest_account_id, $period)
                        ->getMonthlyBalanceRecord($monthlyBalance->invest_account_id, $period);
                }

                return $entity;
            });
    }

    public function getMonthlyBalance(InvestAccount|int $investAccount, Carbon $period)
    {
        $accountId = optional($investAccount)->id ?? $investAccount;

        $entity = $this->getMonthlyBalanceRecord($accountId, $period);

        if ($entity === null) {
            $entity = $this->syncMonthlyBalance($accountId, $period)
                ->getMonthlyBalanceRecord($accountId, $period);
        }

        return $entity;
    }

    public function getMonthlyBalanceRecord(int $investAccount, Carbon $period): ?InvestMonthlyBalance
    {
        return InvestMonthlyBalanceRepository::make()->fetch($investAccount, $period->format('Ym'));
    }

    /**
     * 重新計算history數值
     * @param int $investAccount
     * @param Carbon $dealAt
     * @return $this
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

    public function saveMonthlyBalanceCalculator(int $investAccount, Carbon $period, CalculateMonthlyBalance $calculate): self
    {
        InvestMonthlyBalanceRepository::make()->create(
            investAccountId: $investAccount,
            period: $period->format('Ym'),
            deposit: $calculate->deposit,
            transfer: $calculate->transfer,
            withdraw: $calculate->withdraw,
//            commitment: $commitment,
//            weight: $commitment->div(5000)->floor(),
            profit: $calculate->profit,
            expense: $calculate->expense,
            balance: $calculate->balance()
        );

        return $this;
    }

    /**
     * 計算month balance數值
     * @param int $investAccount
     * @param Carbon $period
     * @return CalculateMonthlyBalance
     */
    public function calcMonthBalance(int $investAccount, Carbon $period): CalculateMonthlyBalance
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

        return $calculateMonthlyBalance;
    }

    public function syncMonthlyBalance(int $investAccount, Carbon $period): self
    {
        $this->saveMonthlyBalanceCalculator(
            $investAccount,
            $period,
            $this->calcMonthBalance($investAccount, $period)
        );

        return $this;
    }

    public function newPeriodMonthlyBalance(Carbon $period)
    {
        $repository = InvestMonthlyBalanceRepository::make();

        return $repository
            ->fetchByPeriod($period->firstOfMonth()->subMonth()->format('Ym'))
            ->filter(fn(InvestMonthlyBalance $monthlyBalance) => $monthlyBalance->balance->moreThan(0))
            ->map(fn(InvestMonthlyBalance $monthlyBalance) => $this->syncMonthlyBalance($monthlyBalance->invest_account_id, $period));
    }

    public function getCommitments(Carbon $period): \Illuminate\Support\Collection
    {
        return $this->getAccounts()
            ->map(fn(InvestAccount $account) => InvestMonthlyBalanceRepository::make()->fetchLast($account->id, $period->format('Ym')))
            ->filter()
            ->mapWithKeys(function (InvestMonthlyBalance $monthlyBalance) use ($period) {
                $balance = $monthlyBalance->balance;

                if ($monthlyBalance->period != $period->format('Ym')) {
                    return [$monthlyBalance->invest_account_id => $balance];
                }

                /**
                 * 可分配權益: 上期結餘+出金+出金轉存
                 * 可分配權益: 當期結餘-入金-損益-費用
                 */
                return [
                    $monthlyBalance->invest_account_id => $monthlyBalance->balance
                        ->sub($monthlyBalance->deposit)
                        ->sub($monthlyBalance->profit)
                        ->sub($monthlyBalance->expense)
                ];
            })
            ->filter(fn(Decimal $commitment) => $commitment->moreThan(0));
    }
}
