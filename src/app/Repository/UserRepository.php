<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    /**
     * @param string $account
     * @return User|null
     */
    public function fetchByAccount(string $account): ?User
    {
        return User::where('account', $account)->first();
    }
}
