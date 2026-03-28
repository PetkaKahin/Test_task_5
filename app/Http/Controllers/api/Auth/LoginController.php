<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\api\Auth\LoginResource;
use App\Services\AuthApiService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthApiService $authApiService
    ) {}

    public function __invoke(LoginRequest $request)
    {
        $token = $this->authApiService->login($request);

        return (new LoginResource(Auth::user()))->additional(['token' => $token]);
    }
}
