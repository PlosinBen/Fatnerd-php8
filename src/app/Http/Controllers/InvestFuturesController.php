<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestFuturesStoreRequest;
use App\Http\Resources\InvestStatementFuturesResource;
use App\Service\Statement\Asset\FuturesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestFuturesController
{
    public function index(FuturesService $futuresService)
    {
        return Inertia::render('InvestFutures/Index', [
            'futuresPaginatedList' => InvestStatementFuturesResource::collection(
                $futuresService->getList()
            )
        ]);
    }

    public function create()
    {
        return Inertia::render('InvestFutures/Create');
    }

    public function store(InvestFuturesStoreRequest $investFuturesStoreRequest, FuturesService $futuresService)
    {
        $futuresService->create(
            $investFuturesStoreRequest->group,
            Carbon::parse($investFuturesStoreRequest->period),
            $investFuturesStoreRequest->commitment,
            $investFuturesStoreRequest->open_profit,
            $investFuturesStoreRequest->write_off_profit,
            $investFuturesStoreRequest->deposit ?? 0,
            $investFuturesStoreRequest->withdraw ?? 0
        );

        return redirect()->route('invest.statement.futures');
    }
}
