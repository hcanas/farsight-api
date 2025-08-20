<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('password', description: 'Must be at least 6 characters long.', example: '123456')]
#[BodyParam('password_confirmation', description: 'Must be the same as password.', example: '123456')]
#[BodyParam('pin', 'numeric', 'Must be 6 digits long.', example: '123456')]
#[BodyParam('pin_confirmation', 'numeric', 'Must be the same as pin.', example: '123456')]
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
