<?php

namespace App\Requests;

use App\Requests\PhoneRequest;

class CardRequest extends PhoneRequest
{
    public function rules()
    {
        return parent::rules() + [
                'card' => ['required', 'card'],
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
            'card.card'    => __('loyalty.empty_field_card'),
        ];
    }
}
