<?php

namespace App\Requests;

class CardRequest extends SmsVerificationRequest
{
    public function rules()
    {
        return parent::rules() + [
            'card' => ['required'],
        ];
    }

    public function getCard(): string
    {
        return $this->input('card');
    }

    public function messages()
    {
        return [
            'card.required' => __('loyalty.empty_field_card'),
            'card.card' => __('loyalty.empty_field_card'),
        ];
    }
}
