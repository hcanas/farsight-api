<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        $errors = collect($validator->errors()->messages())
            ->map(fn ($message) => $message[0])
            ->toArray();

        throw new HttpResponseException(response()->json([
            'message' => 'Unprocessable data',
            'errors' => $errors,
        ], 422));
    }
}
