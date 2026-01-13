<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\FieldException;

interface FieldValidation
{
    /**
     * @throws FieldException
     */
    public function check(array $field, array $contactData):void;
}
