<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler;

abstract class ArrayFieldHandler extends FieldHandler
{
    public abstract static function getArrayPropertyName(): string;
}
