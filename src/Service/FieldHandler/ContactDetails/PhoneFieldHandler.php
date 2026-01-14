<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ContactDetails;
class PhoneFieldHandler extends ContactDetailsFieldHandler
{

    protected function getFieldType(): string
    {
        return 'phone';
    }

    public static function getPropertyName(): string
    {
        return 'phones';
    }
    protected function getArrayValue(array $field): array
    {
        return [
            'phoneType' => 2,
            'phone' => $field['value']
        ];
    }
}
