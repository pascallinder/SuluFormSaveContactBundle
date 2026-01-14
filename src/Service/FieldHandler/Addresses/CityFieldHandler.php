<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses;

class CityFieldHandler extends AddressesFieldHandler
{

    protected function getFieldType(): string
    {
        return "city";
    }

    public static function getPropertyName(): string
    {
        return "city";
    }
}
