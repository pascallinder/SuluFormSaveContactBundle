<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ArrayFieldHandler;

abstract class AddressesFieldHandler extends ArrayFieldHandler
{
    public static function getArrayPropertyName(): string
    {
        return 'addresses';
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

        $addresses = $data[$this->getArrayPropertyName()] ?? [];
        if (!\is_array($addresses)) {
            $addresses = [];
        }

        $address = $addresses[0] ?? null;
        if (!\is_array($address)) {
            $address = [
                "title" => "Adresse",
                "deliveryAddress" => true,
                "primaryAddress" => true,
                "billingAddress" => true,
                "addressType" => 2,
            ];
        }

        $address[$this->getPropertyName()] = $field['value'];
        $addresses[0] = $address;
        $data[$this->getArrayPropertyName()] = $addresses;

        return $data;
    }
}
