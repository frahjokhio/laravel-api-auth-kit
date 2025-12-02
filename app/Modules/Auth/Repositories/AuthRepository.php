<?php

namespace App\Modules\Auth\Repositories;

use App\Models\User;

class AuthRepository
{
    public User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function me(): User
    {
        return auth()->user();  
    }

    public function logout(): bool
    {
        $user = auth()->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return true;
    }
}
