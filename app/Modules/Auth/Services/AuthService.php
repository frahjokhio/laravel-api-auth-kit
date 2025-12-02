<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected AuthRepository $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Register a new user and issue a Sanctum token.
     *
     * @param array $data
     * @return array<string, mixed>
     */
    public function register(array $data): array
    {
        // Ensure password is hashed before creating the user
        $data['password'] = Hash::make($data['password']);

        $user = $this->repository->create($data);;

        // Create a Sanctum token for the new user
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Authenticate a user and issue a Sanctum token.
     *
     * @param string $email
     * @param string $password
     * @return array<string, mixed>
     * @throws ValidationException
     */
    public function login(string $email, string $password): array
    {
        /** @var Model $user */
        $user = $this->repository->model->where('email', $email)->first();
  
        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Revoke old tokens and create a new one
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Get the authenticated user's details.
     *
     * @param Model $user
     * @return Model
     */
    public function me()
    {
        return $this->repository->me();
    }

    /**
     * Log out the current user by revoking the current token.
     *
     * @param Model $user
     * @return bool
     */
    public function logout(): bool
    {
        return $this->repository->logout();
    }
}
