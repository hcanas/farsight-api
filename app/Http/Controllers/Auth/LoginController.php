<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\Unauthenticated;

class LoginController extends Controller
{
    #[Group('Account Management')]
    #[Endpoint('Login')]
    #[Unauthenticated]
    #[ResponseField('message', 'Success or error message.')]
    #[ResponseField('token', 'The generated access token.')]
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = User::where('uuid', $request->validated('uuid'))->first();

        if ($user?->verifyHash($request->validated('password'), 'password')) {
            return response()->json([
                'message' => 'Logged in successfully.',
                'token' => $user->createToken('token')->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'Incorrect password',
        ], 401);
    }
}
