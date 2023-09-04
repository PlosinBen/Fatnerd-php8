<?php

namespace App\Service\MixedEvent;

use App\Contracts\InstanceTrait;
use App\DataCalculator\Statement\ProfitCalculator;
use App\lib\Decimal;
use App\Service\InvestService;
use App\Service\StatementService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StatementDistribute
{
    use InstanceTrait;

    public function execute(Carbon $period)
    {
        $investService = InvestService::make();
        $statementService = StatementService::make();

        $statementService->clearDistribute($period);

        $accountCommitments = $investService->getCommitments($period);

        if ($accountCommitments->count() === 0) {
            return;
        }

        /**
         * @var Collection $accountProfit
         */
        $accountProfit = $accountCommitments->map(fn(Decimal $commitment) => ProfitCalculator::make($period)->setCommitment($commitment));

        $statement = $statementService->updateCommitmentWeightProfit(
            $period,
            $accountProfit->reduce(
                fn(Decimal $carry, ProfitCalculator $calculator) => $carry->add($calculator->commitment),
                Decimal::make()
            ),
            $accountProfit->reduce(
                fn(Decimal $carry, ProfitCalculator $calculator) => $carry->add($calculator->weight),
                Decimal::make()
            )
        );

        $replenishProfit = $accountProfit
            ->each(fn(ProfitCalculator $profitCalculator) => $profitCalculator->setProfitPerWeight($statement->profit_per_weight))
            ->reduce(
                fn(Decimal $carry, ProfitCalculator $calculator) => $carry->sub($calculator->profit),
                $statement->profit
            );

        $accountProfit
            ->tap(fn(Collection $collect) => $collect->get(1)->replenishAdminProfit($replenishProfit))
            ->each(fn(ProfitCalculator $profitCalculator, $accountId) => $statementService->setDistribute(
                $period,
                $accountId,
                $profitCalculator->commitment,
                $profitCalculator->weight,
                $profitCalculator->profit
            ))
            ->each(fn(ProfitCalculator $profitCalculator, $accountId) => $investService->addHistory(
                $accountId,
                $period,
                'profit',
                $profitCalculator->profit,
            ));
    }
}
