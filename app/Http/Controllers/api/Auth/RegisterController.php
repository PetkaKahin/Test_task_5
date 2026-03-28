<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\api\Auth\RegisterResource;
use App\Services\AuthApiService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(
        private readonly AuthApiService $authApiService
    ) {}

    public function __invoke(RegisterRequest $request)
    {
        $token = $this->authApiService->register($request);

        return (new RegisterResource(Auth::user()))->additional(['token' => $token]);
    }
}
