<?php

declare(strict_types=1);

namespace Linderp\SuluFormSaveContactBundle\Tests\Service;

use Linderp\SuluFormSaveContactBundle\Event\DynamicFormSavedContactEvent;
use Linderp\SuluFormSaveContactBundle\Service\DynamicFormHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Basic\FirstNameFieldHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ContactDetails\PhoneFieldHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Special\HiddenSaveToContactsFieldHandler;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\ContactBundle\Contact\ContactManager;
use Sulu\Bundle\ContactBundle\Entity\ContactInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class DynamicFormHandlerTest extends TestCase
{
    public function testItDoesNothingWhenSavingContactsIsDisabled(): void
    {
        $contactManager = $this->createMock(ContactManager::class);
        $contactManager->expects(self::never())->method('save');
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects(self::never())->method('dispatch');

        $handler = new DynamicFormHandler(
            [],
            $contactManager,
            new HiddenSaveToContactsFieldHandler(),
            $eventDispatcher,
        );

        $handler->saveContact(['fields' => [[
            'type' => 'hidden_save_to_contacts',
            'options' => ['saveToContacts' => false],
        ]]], 'de');
    }

    public function testItMapsFieldsSavesTheContactAndDispatchesTheResult(): void
    {
        $contact = $this->createMock(ContactInterface::class);
        $expectedData = [
            'lastName' => '',
            'saveToContacts' => true,
            'categories' => [14],
            'firstName' => 'Ada',
            'contactDetails' => [
                'phones' => [['phoneType' => 2, 'phone' => '+41 44 123 45 67']],
            ],
        ];

        $contactManager = $this->createMock(ContactManager::class);
        $contactManager->expects(self::once())
            ->method('save')
            ->with($expectedData)
            ->willReturn($contact);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects(self::once())
            ->method('dispatch')
            ->with(self::callback(static function (object $event) use ($contact, $expectedData): bool {
                return $event instanceof DynamicFormSavedContactEvent
                    && $event->getContact() === $contact
                    && $event->getContactData() === $expectedData
                    && $event->getLocale() === 'de'
                    && !$event->isExistingContact();
            }))
            ->willReturnArgument(0);

        $hiddenHandler = new HiddenSaveToContactsFieldHandler();
        $handler = new DynamicFormHandler(
            [$hiddenHandler, new FirstNameFieldHandler(), new PhoneFieldHandler()],
            $contactManager,
            $hiddenHandler,
            $eventDispatcher,
        );

        $handler->saveContact(['fields' => [
            [
                'type' => 'hidden_save_to_contacts',
                'options' => ['saveToContacts' => true, 'categoryId' => 14],
            ],
            ['type' => 'firstName', 'value' => 'Ada'],
            ['type' => 'phone', 'value' => '+41 44 123 45 67'],
            ['type' => 'unhandled', 'value' => 'ignored'],
        ]], 'de');
    }
}
