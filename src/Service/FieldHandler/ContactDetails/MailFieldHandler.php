<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\ContactDetails;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\ContactAlreadyExistsException;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldValidation;
use Sulu\Bundle\ContactBundle\Entity\ContactRepositoryInterface;

class MailFieldHandler extends ContactDetailsFieldHandler implements FieldValidation
{
    public function __construct(private readonly ContactRepositoryInterface $contactRepository){

    }
    protected function getFieldType(): string
    {
        return 'email';
    }

    public static function getPropertyName(): string
    {
        return 'emails';
    }

    public function check(array $field, array $contactData): void
    {
      $contact= $this->contactRepository->findByCriteriaEmailAndPhone([],$field['value']);
        if($contact !== null){
            throw new ContactAlreadyExistsException($contact);
        }
    }
    protected function getArrayValue(array $field): array
    {
        return [
            'emailType' => 2,
            'email' => $field['value']
        ];
    }
}
