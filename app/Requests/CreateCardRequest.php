<?php

namespace App\Requests;

class CreateCardRequest extends PhoneRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sessionId'         => ['required'],
            'contactId'         => ['required'],
            'partnerId'         => ['required'],
            'VirtualCardTypeId' => ['required'],
        ];
    }

    public function getSessionId()
    {
        return $this->input('sessionId');
    }

    public function getContactId()
    {
        return $this->input('contactId');
    }

    public function getPartnerId()
    {
        return $this->input('partnerId');
    }

    public function getVirtualCardTypeId()
    {
        return $this->input('virtualCardTypeId');
    }

    public function messages()
    {
        return [
            'sessionId.required' => __('loyalty.sessionId_required'),
            'contactId.required' => __('loyalty.contactId_required'),
            'partnerId.required' => __('loyalty.partnerId_required'),
            'VirtualCardTypeId.required' => __('loyalty.VirtualCardTypeId_required'),
        ];
    }
}
