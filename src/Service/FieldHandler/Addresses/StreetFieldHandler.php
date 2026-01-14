<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses;

class StreetFieldHandler extends AddressesFieldHandler
{

    protected function getFieldType(): string
    {
        return "street";
    }

    public static function getPropertyName(): string
    {
        return "street";
    }
}
