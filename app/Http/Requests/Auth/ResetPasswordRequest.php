<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam(
    'wallet_address',
    description: 'Must be a valid wallet address.',
    example: '0x57d90b64a1a57749b0f932f1a3395792e12e7055'
)]
#[BodyParam('password', description: 'Must be at least 6 characters long.', example: '123456')]
#[BodyParam('password_confirmation', description: 'Must be the same as password.', example: '123456')]
#[BodyParam('pin', type: 'numeric', description: 'The 6-digit pin set during registration.', example: '123456')]
class ResetPasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'wallet_address' => 'bail|required|string|regex:/^[a-zA-Z0-9]{26,64}$/',
            'password' => 'bail|required|string|min:6|confirmed',
            'pin' => 'bail|required|numeric|digits:6',
        ];
    }
}
