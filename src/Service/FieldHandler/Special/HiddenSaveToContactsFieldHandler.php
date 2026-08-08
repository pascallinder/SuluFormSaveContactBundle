<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Special;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldHandler;

class HiddenSaveToContactsFieldHandler extends FieldHandler
{
    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function handleField(array $field, array $data): array
    {
        $options = $field['options'] ?? null;
        if (!\is_array($options) || empty($options['saveToContacts'])) {
            return $data;
        }

        $data[self::getPropertyName()] = true;
        if (isset($options['categoryId'])) {
            $data['categories'] = [$options['categoryId']];
        }
        if (isset($options['defaultFormOfAddress'])) {
            $data['formOfAddress'] = $options['defaultFormOfAddress'];
        }

        return $data;
    }

    protected function getFieldType(): string
    {
        return 'hidden_save_to_contacts';
    }

    public static function getPropertyName(): string
    {
        return 'saveToContacts';
    }
}
