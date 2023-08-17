<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestAccountStoreRequest;
use App\Service\InvestService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestAccountController
{
    public function index(InvestService $investService)
    {
//        dd(
//            $investService->getAccountList()
//        );

        return Inertia::render('InvestAccount/Index');
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
