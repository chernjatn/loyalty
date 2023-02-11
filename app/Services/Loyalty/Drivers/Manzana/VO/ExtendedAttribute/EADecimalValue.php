<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\ExtendedAttribute;

class EADecimalValue extends EAValue
{
    public function __construct(private string $value)
    {
    }

    public function getType(): EAValueType
    {
        return EAValueType::DECIMAL;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    
    public function getRawValue(): string
    {
        return $this->value;
    }
}
