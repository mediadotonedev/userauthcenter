<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\EmailOrIranianMobile;
use Illuminate\Validation\ValidationException;

class UserRegisterRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'min:10',
                new EmailOrIranianMobile,
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:2500',
            ],
            'nickname' => [
                'required_if:show_name,0',
                'string',
                'min:2',
                'max:50',
            ],
            'show_name' => [
                'boolean',
            ],
            'gender' => [
                'in:male,female',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8',
            ],
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
