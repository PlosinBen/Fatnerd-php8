<?php

namespace App\Http\Controllers\Statement;

use App\Http\Controllers\Controller;
use App\Service\StatementService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DistributeController extends Controller
{
    public function index(StatementService $statementService)
    {
        return Inertia::render('Statement/Distribute/Index', [

        ]);
    }
}
