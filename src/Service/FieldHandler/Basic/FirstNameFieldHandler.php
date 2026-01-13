<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic;
class FirstNameFieldHandler extends BaseFieldHandler
{
    protected function getFieldType(): string
    {
        return 'firstName';
    }
    protected function getPropertyName(): string
    {
       return $this->getFieldType();
    }
}
