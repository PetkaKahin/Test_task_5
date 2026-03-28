<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\api\Auth\RegisterResource;
use App\Models\User;
use App\Services\AuthApiService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(
        private readonly AuthApiService $authApiService
    ) {}

    public function __invoke(RegisterRequest $request): JsonResource
    {
        $token = $this->authApiService->register($request);

        /** @var User $user */
        $user = Auth::user();

        return (new RegisterResource($user))->additional(['token' => $token]);
    }
}
