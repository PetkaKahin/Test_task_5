<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthApiService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(
        private readonly AuthApiService $authApiService
    ) {}

    public function __invoke(Request $request)
    {
        $this->authApiService->logout($request);

        return response()->noContent();
    }
}
