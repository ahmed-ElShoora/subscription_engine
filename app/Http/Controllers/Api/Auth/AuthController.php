<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        $user_and_token = $this->authService->register($request->validated());
        return $this->successResponse(
            $user_and_token, 
            'User registered successfully', 
            201
        );
    }

    public function login(LoginRequest $request)
    {
        $user_and_token = $this->authService->login($request->validated());
        return $this->successResponse(
            $user_and_token, 
            'User logged in successfully', 
            200
        );
    }

    public function me()
    {
        $user = $this->authService->me(auth()->user());
        return $this->successResponse(
            $user,
            'User retrieved successfully'
        );
    }

    public function logout()
    {
        $logout_status = $this->authService->logout(auth()->user());
        return $logout_status ? $this->successResponse('User logged out successfully') : $this->errorResponse('Failed to log out user');
    }
}
