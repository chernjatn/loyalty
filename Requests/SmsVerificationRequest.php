<?php

namespace App\Requests;

class SmsVerificationRequest extends PhoneRequest
{
    public function rules()
    {
        return parent::rules() + [
            'verificationCode' => 'required'
        ];
    }

    public function getVerificationCode(): string
    {
        return $this->input('verificationCode');
    }

    public function messages()
    {
        return parent::messages() + [
            'verificationCode.required' => __('validation.custom.sms_verification_code')
        ];
    }
}
