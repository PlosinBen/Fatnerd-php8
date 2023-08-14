<?php

namespace App\Service;

use App\Models\User;
use App\Repository\UserRepository;

class UserService
{
    public function loginByAccount(string $account, string $password): ?User
    {
        /**
         * @var $userRepository UserRepository
         */
        $userRepository = app(UserRepository::class);

        if ($userEntity = $userRepository->fetchByAccount(strtolower($account))) {
            if (password_verify($password, $userEntity->password)) {
                auth()->login($userEntity);

                return $userEntity;
            }
        }

        return null;
    }
}
