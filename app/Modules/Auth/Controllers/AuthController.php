<?php

namespace App\Modules\Auth\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Auth\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Requests\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    protected AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Register a new user.
     * POST /api/auth/register
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->service->register($request->only('name', 'email', 'password'));
            return $this->success($result, 'User registered successfully and token issued.', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Log in an existing user.
     * POST /api/auth/login
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->service->login($request->email, $request->password);
            return $this->success($result, 'Login successful and new token issued.');
        } catch (ValidationException $e) {
            return $this->error($e->getMessage(), Response::HTTP_UNAUTHORIZED, $e->errors());
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred during login.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Log out the current user.
     * POST /api/auth/logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->service->logout($request->user());
        return $this->success(null, 'Successfully logged out.');
    }

    /**
     * Get authenticated user details.
     * GET /api/auth/user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $this->service->me($request->user());
        return $this->success($user, 'Authenticated user details retrieved.');
    }
}
