<?php

namespace App\Service;

use App\Contracts\InstanceTrait;
use App\lib\Decimal;
use App\Models\InvestAccount;
use App\Models\Statement;
use App\Models\StatementAsset;
use App\Models\StatementDistribute;
use App\Repository\InvestMonthlyBalanceRepository;
use App\Repository\StatementAssetRepository;
use App\Repository\StatementDistributeRepository;
use App\Repository\StatementRepository;
use Carbon\Carbon;

class StatementService
{
    use InstanceTrait;

    public function getList()
    {
        return StatementRepository::make()->fetch();
    }

    public function get(Carbon $period): Statement
    {
        return StatementRepository::make()->create($period->format('Ym'));
    }

    public function refresh(Carbon $period): Statement
    {
        return StatementRepository::make()->update(
            period: $period,
            profit: StatementAssetRepository::make()->fetchProfit($period)
        );
    }

    public function updateCommitmentWeightProfit(Carbon $period, Decimal $commitment, Decimal $weight): Statement
    {
        $profit = StatementAssetRepository::make()
            ->fetchByPeriod($period->format('Ym'))
            ->reduce(fn(Decimal $carry, StatementAsset $asset) => $carry->add($asset->profit), Decimal::make());

        return StatementRepository::make()->update(
            period: $period,
            commitment: $commitment,
            weight: $weight,
            profitPerWeight: $profit->div($weight)->floor(),
            profit: $profit
        );
    }

    public function setDistribute(
        Carbon            $period,
        InvestAccount|int $investAccount,
        Decimal           $commitment,
        Decimal           $weight,
        Decimal           $profit
    ): StatementDistribute
    {
        return StatementDistributeRepository::make()->update(
            statementPeriod: $period->format('Ym'),
            investAccountId: optional($investAccount)->id ?? $investAccount,
            commitment: $commitment,
            weight: $weight,
            profit: $profit
        );
    }

    public function updateDistributeCommitment(Carbon $period, InvestAccount|int $investAccount, Decimal $commitment): ?StatementDistribute
    {
        $accountId = optional($investAccount)->id ?? $investAccount;

        $weight = $commitment->div(5000)->floor()->max(0.5);

        if ($commitment->moreThan(0)) {
            return StatementDistributeRepository::make()->update(
                statementPeriod: $period->format('Ym'),
                investAccountId: $accountId,
                commitment: $commitment,
                weight: $weight
            );
        }

        return null;
    }

    public function clearDistribute(Carbon $period)
    {
        StatementDistributeRepository::make()->deleteByPeriod($period->format('Ym'));
    }

    public function updateDistributeProfit(StatementDistribute $statementDistribute, Decimal $profit): StatementDistribute
    {
        return StatementDistributeRepository::make()->updateProfit($statementDistribute, $profit);
    }
}
