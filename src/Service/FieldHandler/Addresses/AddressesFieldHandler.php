<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ArrayFieldHandler;

abstract class AddressesFieldHandler extends ArrayFieldHandler
{
    public static function getArrayPropertyName(): string
    {
        return 'addresses';
    }

    protected function handleField(array $field, array $data): array
    {
        if(!array_key_exists('value',$field) || $field['value'] === null){
            return $data;
        }
        if(!isset($data[$this->getArrayPropertyName()])){
            $data[$this->getArrayPropertyName()] = [[
                "title" => "Adresse",
                "deliveryAddress" => true,
                "primaryAddress" => true,
                "billingAddress" => true,
                "addressType" => 2
            ]];
        }
        $data[$this->getArrayPropertyName()][0][$this->getPropertyName()]= $field['value'];
        return $data;
    }
}
