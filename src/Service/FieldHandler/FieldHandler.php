<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\FieldException;

abstract class FieldHandler
{
    /**
     * @throws FieldException
     */
    public function handle(array $field, array $contactData): array
    {
        if($this instanceof FieldValidation){
            $this->check($field,$contactData);
        }
        return $this->handleField($field,$contactData);
    }
    protected abstract function handleField(array $field, array $data):array;
    protected abstract function getFieldType():string;

    public abstract static function getPropertyName():string;
    public function match(array $field):bool{
        return $field['type'] === $this->getFieldType();
    }
}
