<?php

namespace App\Http\Controllers\InvestAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestHistoryStoreRequest;
use App\Http\Resources\InvestAccountResource;
use App\Service\InvestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index(InvestService $investService)
    {
        return Inertia::render('InvestAdmin/History/Index', [
            'investAccount' => InvestAccountResource::collection(
                $investService->getAccounts([])
            ),
            'historyPaginatedList' => $investService->getHistoryList([])
        ]);
    }

    public function create(InvestService $investService)
    {
        return Inertia::render('InvestAdmin/History/Create', [
            'investAccounts' => InvestAccountResource::collection(
                $investService->getAccounts([])
            ),
            'typeOptions' => config('invest.type')
        ]);
    }

    public function store(InvestHistoryStoreRequest $investHistoryStoreRequest, InvestService $investService)
    {
        $investService->addHistory(
            $investHistoryStoreRequest->invest_account,
            Carbon::parse($investHistoryStoreRequest->deal_at),
            $investHistoryStoreRequest->type,
            $investHistoryStoreRequest->amount,
            $investHistoryStoreRequest->note
        );

        return redirect()->route('invest_admin.history.index');
    }
}
