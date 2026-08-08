<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ContactDetails;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ArrayFieldHandler;

abstract class ContactDetailsFieldHandler extends ArrayFieldHandler
{
    public static function getArrayPropertyName(): string
    {
        return "contactDetails";
    }

    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function handleField(array $field, array $data): array
    {
        if (!isset($field['value'])) {
            return $data;
        }

        $contactDetails = $data[$this->getArrayPropertyName()] ?? [];
        if (!\is_array($contactDetails)) {
            $contactDetails = [];
        }

        $values = $contactDetails[$this->getPropertyName()] ?? [];
        if (!\is_array($values)) {
            $values = [];
        }

        $values[] = $this->getArrayValue($field);
        $contactDetails[$this->getPropertyName()] = $values;
        $data[$this->getArrayPropertyName()] = $contactDetails;

        return $data;
    }

    /**
     * @param array<string, mixed> $field
     *
     * @return array<string, mixed>
     */
    abstract protected function getArrayValue(array $field): array;
}
