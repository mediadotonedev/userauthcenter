<?php

namespace Mediadotonedev\UserAuthCenter\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailOrIranianMobile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $mobile = preg_replace('/[^0-9]/', '', $value);

        if (str_starts_with($mobile, '0098')) {
            $mobile = substr($mobile, 4);
        } elseif (str_starts_with($mobile, '98')) {
            $mobile = substr($mobile, 2);
        } elseif (str_starts_with($mobile, '+98')) {
            $mobile = substr($mobile, 3);
        }

        if (str_starts_with($mobile, '9')) {
            $mobile = '0' . $mobile;
        }

        if (strlen($mobile) !== 11 || !preg_match('/^09[0-9]{9}$/', $mobile)) {
            $fail('The :attribute field must be a valid Iranian email or mobile number.');
        }
    }
}
