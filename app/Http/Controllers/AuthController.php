<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class AuthController extends Controller
{
    public function __construct(protected readonly AuthService $authService)
    {

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data=$this->authService->register(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );
        return response()->json(array('token'=>$data));
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->attemptLogin($credentials);

        if (! $result['success']) {
            return response()->json(['error' => $result['error']], $result['status']);
        }

        return response()->json(['token' => $result['token']]);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function publicKey(): BinaryFileResponse
    {
        return response()->file(base_path('keys/jwt_public.key'));
    }
}

