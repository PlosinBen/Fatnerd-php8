<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatementResource;
use App\Service\StatementService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatementController extends Controller
{
    public function index(StatementService $statementService)
    {
        return Inertia::render('Statement/Index', [
            'statementPaginatedList' => StatementResource::collection(
                $statementService->getList()
            )
        ]);
    }

    public function distribute()
    {

    }
}
