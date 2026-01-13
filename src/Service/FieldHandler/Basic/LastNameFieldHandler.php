<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic;
class LastNameFieldHandler extends BaseFieldHandler
{
    protected function getFieldType(): string
    {
        return 'lastName';
    }
    protected function getPropertyName(): string
    {
        return $this->getFieldType();
    }
}
