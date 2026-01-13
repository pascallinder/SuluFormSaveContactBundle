<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ContactDetails;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldHandler;

abstract class ContactDetailsFieldHandler extends FieldHandler
{
    protected function handleField(array $field, array $data): array
    {
        if(!array_key_exists('value',$field) || $field['value'] === null){
            return $data;
        }
        if(!isset($data['contactDetails'])){
            $data['contactDetails'] = [];
        }
        if(!isset($data['contactDetails'][$this->getPropertyName()])){
            $data['contactDetails'][$this->getPropertyName()]=[];
        }
        $data['contactDetails'][$this->getPropertyName()][]= $this->getArrayValue($field);
        return $data;
    }

    protected abstract function getArrayValue(array $field):array;
}
