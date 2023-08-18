<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestAccountStoreRequest;
use App\Http\Resources\InvestStatementFuturesResource;
use App\Service\InvestService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestAccountController
{
    public function index(InvestService $investService)
    {
        return Inertia::render('InvestAccount/Index', [
            'accountPaginatedList' => $investService->getAccountList()
        ]);
    }

    public function create()
    {
        return Inertia::render('InvestAccount/Create');
    }

    public function store(InvestAccountStoreRequest $investAccountStoreRequest, InvestService $investService)
    {
        $investService->createAccount(
            $investAccountStoreRequest->alias
        );

        return redirect()->route('invest.account.index');
    }
}
