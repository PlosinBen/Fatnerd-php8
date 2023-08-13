<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Login/Index');
    }

    public function store(LoginRequest $loginRequest)
    {
        dd(
            $loginRequest
        );
    }
}
