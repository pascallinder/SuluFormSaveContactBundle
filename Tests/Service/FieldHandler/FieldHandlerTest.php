<?php

declare(strict_types=1);

namespace Linderp\SuluFormSaveContactBundle\Tests\Service\FieldHandler;

use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses\CityFieldHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Addresses\StreetFieldHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic\FirstNameFieldHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ContactDetails\PhoneFieldHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Special\HiddenSaveToContactsFieldHandler;
use PHPUnit\Framework\TestCase;

final class FieldHandlerTest extends TestCase
{
    public function testBasicHandlerMatchesAndMapsItsField(): void
    {
        $handler = new FirstNameFieldHandler();

        self::assertTrue($handler->match(['type' => 'firstName']));
        self::assertFalse($handler->match(['type' => 'lastName']));
        self::assertSame(
            ['lastName' => '', 'firstName' => 'Ada'],
            $handler->handle(['type' => 'firstName', 'value' => 'Ada'], ['lastName' => '']),
        );
        self::assertSame(
            ['lastName' => ''],
            $handler->handle(['type' => 'firstName'], ['lastName' => '']),
        );
    }

    public function testAddressHandlersBuildOneCompletePrimaryAddress(): void
    {
        $data = (new StreetFieldHandler())->handle(['type' => 'street', 'value' => 'Main Street 1'], []);
        $data = (new CityFieldHandler())->handle(['type' => 'city', 'value' => 'Zürich'], $data);

        self::assertSame([
            'addresses' => [[
                'title' => 'Adresse',
                'deliveryAddress' => true,
                'primaryAddress' => true,
                'billingAddress' => true,
                'addressType' => 2,
                'street' => 'Main Street 1',
                'city' => 'Zürich',
            ]],
        ], $data);
    }

    public function testContactDetailHandlerAppendsValues(): void
    {
        $handler = new PhoneFieldHandler();
        $data = $handler->handle(['type' => 'phone', 'value' => '+41 44 123 45 67'], []);
        $data = $handler->handle(['type' => 'phone', 'value' => '+41 79 765 43 21'], $data);

        self::assertSame([
            'contactDetails' => [
                'phones' => [
                    ['phoneType' => 2, 'phone' => '+41 44 123 45 67'],
                    ['phoneType' => 2, 'phone' => '+41 79 765 43 21'],
                ],
            ],
        ], $data);
    }

    public function testHiddenFieldControlsSavingAndDefaults(): void
    {
        $handler = new HiddenSaveToContactsFieldHandler();

        self::assertSame([], $handler->handle([
            'type' => 'hidden_save_to_contacts',
            'options' => ['saveToContacts' => false],
        ], []));
        self::assertSame([
            'saveToContacts' => true,
            'categories' => [14],
            'formOfAddress' => 2,
        ], $handler->handle([
            'type' => 'hidden_save_to_contacts',
            'options' => [
                'saveToContacts' => true,
                'categoryId' => 14,
                'defaultFormOfAddress' => 2,
            ],
        ], []));
    }
}
