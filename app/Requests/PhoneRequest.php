<?php

namespace App\Requests;

use App\Entity\Phone;
use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'regex:/^7[0-9]{10}$/'],
        ];
    }

    public function getPhone()
    {
        return Phone::parse($this->route('clientTel'));
    }

    public function messages()
    {
        return [
            'phone.required' => __('customer.phone_required'),
            'phone.regex' => __('customer.phone_mallformed'),
        ];
    }
}
