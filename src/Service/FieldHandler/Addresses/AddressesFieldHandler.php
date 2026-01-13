<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldHandler;

abstract class AddressesFieldHandler extends FieldHandler
{
    protected function handleField(array $field, array $data): array
    {
        if(!array_key_exists('value',$field) || $field['value'] === null){
            return $data;
        }
        if(!isset($data['addresses'])){
            $data['addresses'] = [[
                "title" => "Adresse",
                "deliveryAddress" => true,
                "primaryAddress" => true,
                "billingAddress" => true,
                "addressType" => 2
            ]];
        }
        $data['addresses'][0][$this->getPropertyName()]= $field['value'];
        return $data;
    }
}
