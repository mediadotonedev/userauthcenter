<?php

namespace Mediadotonedev\UserAuthCenter\Http\Requests;

use Mediadotonedev\UserAuthCenter\Rules\EmailOrIranianMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRegisterVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'username' => ['required','string','min:10',
                new EmailOrIranianMobile,
                ],
                'code' => ['required','numeric','digits:6'],
        ];
    }


    /**
    * Handle failed validation.
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation Errors:',
            'errors' => $validator->errors(),
        ], 422));
    }
}
