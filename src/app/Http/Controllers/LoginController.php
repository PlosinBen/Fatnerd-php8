<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Service\UserService;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Login/Index');
    }

    public function store(LoginRequest $loginRequest, UserService $userService)
    {
        $userEntity = $userService->loginByAccount(
            $loginRequest->account,
            $loginRequest->password
        );

        if ($userEntity === null) {
            return back()->withErrors([
                'password' => '帳號或密碼錯誤',
            ]);
        }

        return redirect('/');
    }
}
