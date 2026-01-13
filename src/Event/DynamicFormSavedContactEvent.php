<?php

namespace Linderp\SuluFormSaveContactBundle\Event;


use Sulu\Bundle\ContactBundle\Entity\ContactInterface;
use Symfony\Contracts\EventDispatcher\Event;

class DynamicFormSavedContactEvent extends Event
{
    public function __construct(private readonly ContactInterface $contact,
                                private readonly array $contactData,
                                private readonly string $locale){

    }
    public function getContact(): ContactInterface
    {
        return $this->contact;
    }

    public function getContactData(): array
    {
        return $this->contactData;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
