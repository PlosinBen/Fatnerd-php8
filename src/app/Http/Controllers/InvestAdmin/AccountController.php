<?php

namespace App\Http\Controllers\InvestAdmin;

use App\Http\Requests\InvestAccountStoreRequest;
use App\Service\InvestService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController
{
    public function index(InvestService $investService)
    {
        return Inertia::render('InvestAdmin/Account/Index', [
            'accountPaginatedList' => $investService->getAccountList()
        ]);
    }

    public function create()
    {
        return Inertia::render('InvestAdmin/Account/Create');
    }

    public function store(InvestAccountStoreRequest $investAccountStoreRequest, InvestService $investService)
    {
        $investService->createAccount(
            $investAccountStoreRequest->alias
        );

        return redirect()->route('invest.account.index');
    }
}
