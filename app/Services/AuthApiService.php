<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthApiService
{
    /**
     * Если логин прошел удачно - возвращает token
     * Если нет - ошибка валидации
     */
    public function login(LoginRequest $request): string
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Неверный email или пароль.'],
            ]);
        }

        $user = Auth::user();

        return $this->getToken($user);
    }

    /**
     * Если регистрация прошла удачно - возвращает token
     * Если нет - ошибка валидации
     */
    public function register(RegisterRequest $request): string
    {
        $user = User::query()->create($request->validated());

        Auth::login($user);

        return $this->getToken($user);
    }

    public function logout(Request $request): void
    {
        $token = $request->user()->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }
    }

    private function getToken(User $user): string
    {
        return $user->createToken('api')->plainTextToken;
    }
}