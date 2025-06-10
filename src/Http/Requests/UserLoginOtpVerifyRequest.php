<?php

namespace Mohsen\UserAuthCenter\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Mohsen\UserAuthCenter\Rules\EmailOrIranianMobile;

class UserLoginOtpVerifyRequest extends FormRequest
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
            'username' => ['required', 'string', 'min:10', 'max:255', new EmailOrIranianMobile],
            'code' => ['required','digits:6'],
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
