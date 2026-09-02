<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\FieldException;

abstract class FieldHandler
{
    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $contactData
     * @return array<string, mixed>
     *
     * @throws FieldException
     */
    public function handle(array $field, array $contactData): array
    {
        if ($this instanceof FieldValidation) {
            $this->check($field, $contactData);
        }
        return $this->handleField($field, $contactData);
    }
    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    abstract protected function handleField(array $field, array $data): array;
    abstract protected function getFieldType(): string;

    abstract public static function getPropertyName(): string;
    /** @param array<string, mixed> $field */
    public function match(array $field): bool
    {
        return $field['type'] === $this->getFieldType();
    }
}
