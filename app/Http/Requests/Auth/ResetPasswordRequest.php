<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

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
