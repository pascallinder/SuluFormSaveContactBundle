<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception;

use Sulu\Bundle\ContactBundle\Entity\ContactInterface;

class ContactAlreadyExistsException extends FieldException
{
    private ContactInterface $contact;
    public function __construct(ContactInterface $contact)
    {
        parent::__construct();
        $this->contact = $contact;
    }

    public function getContact(): ContactInterface
    {
        return $this->contact;
    }
}
