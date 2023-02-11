<?php

namespace App\Services\Validation;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^79[0-9]{9}$/', $value);
    }

    public function message()
    {
        return __('customer.phone_mallformed');
    }
}
