<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'password' => $request->validated('password'),
            'pin' => $request->validated('pin'),
        ]);

        return response()->json([
            'message' => 'Your account has been created.',
            'uuid' => $user->uuid,
        ], 201);
    }
}
