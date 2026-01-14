<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ContactDetails;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ArrayFieldHandler;

abstract class ContactDetailsFieldHandler extends ArrayFieldHandler
{
    public static function getArrayPropertyName(): string
    {
        return "contactDetails";
    }

    protected function handleField(array $field, array $data): array
    {
        if(!array_key_exists('value',$field) || $field['value'] === null){
            return $data;
        }
        if(!isset($data[$this->getArrayPropertyName()])){
            $data[$this->getArrayPropertyName()] = [];
        }
        if(!isset($data[$this->getArrayPropertyName()][$this->getPropertyName()])){
            $data[$this->getArrayPropertyName()][$this->getPropertyName()]=[];
        }
        $data[$this->getArrayPropertyName()][$this->getPropertyName()][]= $this->getArrayValue($field);
        return $data;
    }

    protected abstract function getArrayValue(array $field):array;
}
