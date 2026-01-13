<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldHandler;

abstract class BaseFieldHandler extends FieldHandler
{
    public function handleField(array $field, array $data): array
    {
        if(!array_key_exists('value',$field) || $field['value'] === null){
            return $data;
        }
        $data[$this->getPropertyName()]= $field['value'];
        return $data;
    }
}
