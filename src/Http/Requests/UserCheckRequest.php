<?php

namespace Mediadotonedev\UserAuthCenter\Http\Requests;

use Mediadotonedev\UserAuthCenter\Rules\EmailOrIranianMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class UserCheckRequest extends FormRequest
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
            //
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

    /**
     * Handle passed validation.
     */
    protected function passedValidation()
    {
        $username = $this->input('username');
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $this->merge([
                'email' => $username,
            ]);
        } else {
            $this->merge([
                'phone' => $username,
            ]);
        }
    }

    /**
     * Prepare the request data for validation.
     */
    protected function prepareForValidation()
    {
        $username = $this->input('username');

        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $username = $this->normalizeIranianMobile($username);
        }

        $this->merge([
            'username' => $username,
        ]);
    }

        /**
     * Normalize an Iranian mobile number.
     */
    private function normalizeIranianMobile(string $mobile): string
    {
        // remove all non-digit characters
        $mobile = preg_replace('/[^0-9]/', '', $mobile);

        // remove international code
        if (str_starts_with($mobile, '0098')) {
            $mobile = substr($mobile, 4);
        } elseif (str_starts_with($mobile, '98')) {
            $mobile = substr($mobile, 2);
        } elseif (str_starts_with($mobile, '+98')) {
            $mobile = substr($mobile, 3);
        }

        // remove leading zeros
        if (str_starts_with($mobile, '9')) {
            $mobile = '0' . $mobile;
        }

        // add leading zero if necessary
        if (strlen($mobile) !== 11 || !preg_match('/^09[0-9]{9}$/', $mobile)) {
            throw ValidationException::withMessages([
                'username' => 'email | phone number invalid',
            ]);
        }
        return $mobile;
    }
}
