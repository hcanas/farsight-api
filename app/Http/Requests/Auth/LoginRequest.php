<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam(
    'uuid',
    description: 'The user UUID generated during registration.',
    example: '8d12f965-3c2a-4d7e-91ef-5a1b2c6d8e34'
)]
#[BodyParam('password', description: 'The password of the user.', example: '123456')]
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'bail|required|uuid|exists:users,uuid',
            'password' => 'bail|required|string|min:6',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Incorrect password',
        ], 422));
    }
}
