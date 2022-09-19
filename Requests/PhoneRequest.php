<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Ultra\Shop\Services\Validation\PhoneRule;
//use Ultra\Shop\VO\Phone;

class PhoneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required|regex:/^7[0-9]{10}$/'],
        ];
    }

    public function getPhone()
    {
        return $this->input('clientTel');
    }

    public function messages()
    {
        return [
            'phone.required' => __('customer.phone_required'),
        ];
    }
}
