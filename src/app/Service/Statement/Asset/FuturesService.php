<?php

namespace App\Service\Statement\Asset;

use App\lib\Decimal;
use App\Repository\StatementFuturesRepository;
use App\Repository\StatementRepository;
use App\Service\Statement\AssetService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class FuturesService
{
    public function getList(): LengthAwarePaginator
    {
        $investStatementFuturesRepository = StatementFuturesRepository::make();

        return $investStatementFuturesRepository->fetchList();
    }

    public function create(
        string         $group,
        Carbon         $period,
        int|float      $commitment,
        int|float      $openProfit,
        int|float|null $closeProfit = null,
        int|float      $deposit = 0,
        int|float      $withdraw = 0
    )
    {
        $investStatementFuturesRepository = StatementFuturesRepository::make();

        # fetch previous period
        $previousStatementFutures = $investStatementFuturesRepository->fetchByPeriodGroup(
            $period->copy()->startOfMonth()->subMonth(),
            $group
        );

        $realCommitment = Decimal::make($commitment)->sub($openProfit);

        $commitmentProfit = $profit = 0;
        if ($previousStatementFutures) {
            /**
             * 實質權益損益
             * 實質權益-上期實質權益-出入金淨額[入金-出金]
             * 實質權益-上期實質權益-入金+出金
             */
            $profit = $commitmentProfit = $realCommitment
                ->sub($previousStatementFutures->real_commitment)
                ->sub($deposit)
                ->add($withdraw);

            if ($closeProfit) {
                $profit = $commitmentProfit->min($closeProfit);
            }
        }

        $entity = $investStatementFuturesRepository->insert(
            $group,
            $period,
            $commitment,
            $openProfit,
            $closeProfit,
            $deposit,
            $withdraw,
            $realCommitment,
            $commitmentProfit,
            $profit
        );

        AssetService::make()->create(
            $period,
            'futures',
            $investStatementFuturesRepository->fetchFuturesProfit($period)
        );

        return $entity;
    }
}
