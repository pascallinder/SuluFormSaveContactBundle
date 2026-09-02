<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\FieldException;

interface FieldValidation
{
    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $contactData
     *
     * @throws FieldException
     */
    public function check(array $field, array $contactData): void;
}
