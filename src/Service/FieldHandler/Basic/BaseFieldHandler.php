<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldHandler;

abstract class BaseFieldHandler extends FieldHandler
{
    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function handleField(array $field, array $data): array
    {
        if (!isset($field['value'])) {
            return $data;
        }
        $data[$this->getPropertyName()] = $field['value'];
        return $data;
    }
}
