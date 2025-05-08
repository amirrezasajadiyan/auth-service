<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

readonly class AuthService
{
    public function __construct(public UserRepositoryInterface $userRepository)
    {

    }

    public function register(string $name, string $email, string $password)
    {
        $user=$this->userRepository->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]
        );
        $token=JWTAuth::fromUser($user);
        return response()->json(['token'=>$token]);
    }
    public function attemptLogin(array $credentials)
    {
        if (! $token = JWTAuth::attempt($credentials)) {
            return [
                'success' => false,
                'error' => 'Unauthorized',
                'status' => 401
            ];
        }

        return [
            'success' => true,
            'token' => $token
        ];
    }
}
