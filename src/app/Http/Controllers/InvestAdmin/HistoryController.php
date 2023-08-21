<?php

namespace App\Http\Controllers\InvestAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvestAccountResource;
use App\Service\InvestService;
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
}
