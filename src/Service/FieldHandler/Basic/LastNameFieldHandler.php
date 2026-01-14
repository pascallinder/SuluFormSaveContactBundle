<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic;
class LastNameFieldHandler extends BaseFieldHandler
{
    protected function getFieldType(): string
    {
        return 'lastName';
    }
    public static function getPropertyName(): string
    {
        return 'lastName';
    }
}
