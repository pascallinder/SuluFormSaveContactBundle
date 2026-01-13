<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses;

class ZipFieldHandler extends AddressesFieldHandler
{

    protected function getFieldType(): string
    {
        return "zip";
    }

    protected function getPropertyName(): string
    {
        return "zip";
    }
}
