<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class RegisterRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'bail|required|string|min:6|confirmed',
            'pin' => 'bail|required|numeric|digits:6|confirmed',
        ];
    }
}
