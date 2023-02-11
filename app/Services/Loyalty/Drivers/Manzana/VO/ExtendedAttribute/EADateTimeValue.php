<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\ExtendedAttribute;

use Carbon\Carbon;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\ManzanaLoyaltyDriver;

class EADateTimeValue extends EAValue
{
    public function __construct(private Carbon $value)
    {
    }

    public function getType(): EAValueType
    {
        return EAValueType::DATETIME;
    }

    public function getValue(): Carbon
    {
        return $this->value;
    }

    public function getRawValue(): string
    {
        return $this->value->format(ManzanaLoyaltyDriver::DATE_FORMAT);
    }
}
