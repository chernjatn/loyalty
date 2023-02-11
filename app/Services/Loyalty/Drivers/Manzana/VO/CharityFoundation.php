<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO;

use Ultra\Shop\Contracts\Loyalty\CharityFoundation as CharityFoundationContract;

class CharityFoundation implements CharityFoundationContract
{
    protected string $id;
    protected string $name;
    protected string $bonuscard;

    public function __construct(string $id, string $name, string $bonuscard)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonuscard = $bonuscard;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function getBonuscard(): string
    {
        return $this->bonuscard;
    }
}
