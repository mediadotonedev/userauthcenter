<?php

namespace Mediadotonedev\UserAuthCenter\Http\Requests;

use Mediadotonedev\UserAuthCenter\Rules\EmailOrIranianMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserResendRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:10', new EmailOrIranianMobile],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation Errors:',
            'errors' => $validator->errors(),
        ], 422));
    }
}