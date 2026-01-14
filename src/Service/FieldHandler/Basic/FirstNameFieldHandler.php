<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic;
class FirstNameFieldHandler extends BaseFieldHandler
{
    protected function getFieldType(): string
    {
        return 'firstName';
    }
    public static function getPropertyName(): string
    {
       return 'firstName';
    }
}
