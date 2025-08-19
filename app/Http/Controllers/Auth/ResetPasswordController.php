<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
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
