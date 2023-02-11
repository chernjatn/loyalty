<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\ExtendedAttribute;

use Carbon\Carbon;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\ManzanaLoyaltyDriver;

abstract class EAValue
{
    public static function fromRaw(array $rawAttribute): self
    {
        $type  = EAValueType::from($rawAttribute['Type']);
        $value = $rawAttribute[self::getRawValueKey($type)];

        switch ($type) {
            case EAValueType::DECIMAL:
                return new EADecimalValue($value);
            case EAValueType::TEXT:
                return new EATextValue($value);
            case EAValueType::DATETIME:
                return new EADateTimeValue(Carbon::createFromFormat(ManzanaLoyaltyDriver::DATE_FORMAT, $value));
        }

        throw new ClassNotFoundException($rawAttribute['Type']);
    }

    public static function getRawValueKey(EAValueType $type): string
    {
        return match ($type) {
            EAValueType::DECIMAL  => 'Decimal',
            EAValueType::TEXT     => 'Text',
            EAValueType::DATETIME => 'DateTime',
        };
    }

    abstract public function getValue();
    abstract public function getRawValue();
    abstract public function getType(): EAValueType;
}
