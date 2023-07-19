<?php

namespace App\Requests;

class SmsVerificationRequest extends PhoneRequest
{
    public function rules()
    {
        return parent::rules() + [
            'sentCode' => 'string',
            'verificationCode' => 'required|same:sentCode',
        ];
    }

    public function getVerificationCode(): string
    {
        return $this->input('verificationCode');
    }

    public function getSentCode(): string
    {
        return $this->input('sentCode');
    }

    public function messages()
    {
        return parent::messages() + [
            'verificationCode.required' => __('validation.custom.sms_verification_code'),
            'verificationCode.same' => __('validation.custom.sms_verification_wrong'),
        ];
    }
}
