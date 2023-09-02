<?php

namespace App\Service\MixedEvent;

use App\Contracts\InstanceTrait;
use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Service\InvestService;
use App\Service\StatementService;
use Carbon\Carbon;
use App\Models\StatementDistribute as DistributeModel;

class StatementDistribute
{
    use InstanceTrait;

    public function execute(Carbon $period)
    {
        $investService = InvestService::make();
        $statementService = StatementService::make();

        $statementService->clearDistribute($period);

        # 取得投資期間帳號
        $accountDistributes = $investService->getAccounts()
            ->filter(fn(InvestAccount $investAccount) => $period->isBetween($investAccount->start_period_carbon, $investAccount->end_period_carbon))
            ->mapWithKeys(function (InvestAccount $investAccount) use ($investService, $statementService, $period) {
                $investMonthlyBalance = $investService->calcMonthBalance($investAccount, $period)->getMonthlyBalance($investAccount, $period);

                /**
                 * 可分配權益: 上期結餘+出金+出金轉存
                 * 可分配權益: 當期結餘-入金-損益-費用
                 */
                return [
                    $investAccount->id => $statementService->updateDistributeCommitment(
                        $period,
                        $investAccount,
                        $investMonthlyBalance->balance
                            ->sub($investMonthlyBalance->deposit)
                            ->sub($investMonthlyBalance->profit)
                            ->add($investMonthlyBalance->expense)
                    )
                ];
            })
            ->filter();

        /**
         * @var Decimal $totalCommitment
         */
        $totalCommitment = $accountDistributes->reduce(function (Decimal $carry, DistributeModel $distribute) {
            return $carry->add($distribute->commitment);
        }, Decimal::make());

        $totalWeight = $accountDistributes->reduce(function (Decimal $carry, DistributeModel $distribute) {
            return $carry->add($distribute->weight);
        }, Decimal::make());

        $statement = $statementService->get($period);

        $profitPerWeight = $statement->profit->div($totalWeight)->floor();

        $statement = $statementService->updateCommitmentWeight($period, $totalCommitment, $totalWeight, $profitPerWeight);

        $profit = $statement->profit;

        /**
         * @var DistributeModel $adminDistribute
         */
        $adminDistribute = $accountDistributes->pull(1);

        $accountDistributes->map(function (DistributeModel $distribute) use ($statementService, $investService, $profitPerWeight, $period, &$profit) {
            $accountProfit = $profitPerWeight->mul($distribute->weight)->floor();

            $investService->addHistory(
                $distribute->invest_account_id,
                $period,
                'profit',
                $accountProfit,
            );

            return $statementService->updateDistributeProfit($distribute, $accountProfit);
        });

        $adminProfit = $statement->profit->sub(
            $accountDistributes->reduce(fn(Decimal $carry, DistributeModel $distribute) => $carry->add($distribute->profit), Decimal::make())
        );

        $statementService->updateDistributeProfit(
            $adminDistribute,
            $adminProfit
        );

        $investService->addHistory(
            1,
            $period,
            'profit',
            $adminProfit,
        );
    }
}
