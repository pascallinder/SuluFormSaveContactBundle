<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler;

abstract class ArrayFieldHandler extends FieldHandler
{
    abstract public static function getArrayPropertyName(): string;
}
