<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO;

use Ultra\Shop\VO\Phone;

class Contact
{
    protected string $id;
    protected Phone $phone;

    public function __construct(string $id, Phone $phone)
    {
        $this->id = $id;
        $this->phone = $phone;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
