<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\Unauthenticated;

class RegisterController extends Controller
{
    #[Group('Account Management')]
    #[Endpoint('Register', 'Create a new account with password and pin.')]
    #[Unauthenticated]
    #[ResponseField('message', 'Success message.')]
    #[ResponseField('uuid', 'The generated UUID for the user which serves as the identifier.')]
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
