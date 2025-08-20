<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\Unauthenticated;

class ResetPasswordController extends Controller
{
    #[Group('Account Management')]
    #[Endpoint(
        'Reset Password',
        'Set a new password by providing a wallet address linked to the user and the correct pin.',
    )]
    #[Unauthenticated]
    #[ResponseField('message', 'string', 'Success or error message.')]
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        $user = User::query()
            ->whereHas('wallets', function ($query) use ($request) {
                $query->where('address', $request->validated('wallet_address'));
            })->first();

        if ($user?->verifyHash($request->validated('pin'), 'pin')) {
            $user->fill(['password' => $request->validated('password')])->save();

            return response()->json([
                'message' => 'New password has been set.',
            ]);
        }

        return response()->json([
            'message' => 'Failed to verify identity.',
        ]);
    }
}
