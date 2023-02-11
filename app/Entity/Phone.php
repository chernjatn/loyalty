<?php

namespace App\Entity;

use Serializable;
use Stringable;
use Illuminate\Support\Facades\Validator;

class Phone implements Serializable, Stringable
{
    private string $phone;

    public function __construct(string $phone)
    {
        $this->setPhone($phone);
    }

    public static function parse(string $phoneString): self
    {
        $phone = preg_replace('/[^0-9]+/', '', $phoneString);

        if (!empty($phone) && $phone[0] !== '7') {
            if (strlen($phone) === 10) {
                $phone = '7' . $phone;
            } elseif (strlen($phone) === 11) {
                $phone[0] = '7';
            }
        }

        return new static($phone);
    }

    public function getPhoneNumber(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone)
    {
        Validator::make(['phone' => $phone], ['phone' => ['regex:/^7[0-9]{10}$/']])->validate();

        $this->phone = $phone;

        return $this;
    }

    public function __toString()
    {
        return $this->phone;
    }

    public function __serialize(): array
    {
        return [
            'phone' => $this->phone
        ];
    }

    /** @deprecated */
    public function serialize()
    {
        return serialize($this->__serialize());
    }

    public function __unserialize(array $data): void
    {
        $this->phone = $data['phone'];
    }

    /** @deprecated */
    public function unserialize($data)
    {
        $this->__unserialize(unserialize($data));
    }

    public function is(Phone $phone): bool
    {
        return $this->phone === $phone->getPhoneNumber();
    }
}
