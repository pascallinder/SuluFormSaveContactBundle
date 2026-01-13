<?php

namespace Linderp\SuluFormSaveContactBundle\Service;

use Linderp\SuluFormSaveContactBundle\Event\DynamicFormSavedContactEvent;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\ContactAlreadyExistsException;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldHandler;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldValidation;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Special\HiddenSaveToContactsFieldHandler;
use Sulu\Bundle\ContactBundle\Contact\ContactManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

readonly class DynamicFormHandler
{
    /**
     * @param iterable<FieldHandler> $fieldHandlers
     */
    public function __construct(
        private iterable                $fieldHandlers,
        private ContactManagerInterface $contactManager,
        private HiddenSaveToContactsFieldHandler $hiddenSaveToContactsFieldHandler,
        private EventDispatcherInterface $eventDispatcher
    ){

    }
    private function hasSaveContactField(array $form):bool
    {
        foreach ($form['fields'] as $field) {
            if($this->hiddenSaveToContactsFieldHandler->match($field)){
                return $this->hiddenSaveToContactsFieldHandler->handle($field,[])['saveToContacts'];
            }
        }
        return false;
    }

    public function saveContact(array $form, string $locale):void
    {
        if(!$this->hasSaveContactField($form)){
            return;
        }
        $contactData = [];
        $existingContact = null;
        foreach ($form['fields'] as $field) {
            foreach ($this->fieldHandlers as $fieldHandler){
                if(!$fieldHandler->match($field)){
                    continue;
                }
                try {
                    $contactData = $fieldHandler->handle($field, $contactData);
                } catch (FieldValidation $e) {
                    if($e instanceof ContactAlreadyExistsException){
                        $existingContact = $e->getContact();
                    }
                    continue;
                }
            }
        }
        if (!array_key_exists('lastName', $contactData)) {
            $contactData['lastName'] = '';
        }
        if (!array_key_exists('formOfAddress', $contactData)) {
            $contactData['formOfAddress'] = 2;
        }
        $contact = $existingContact ?? $this->contactManager->save(
            $contactData
        );
        $this->eventDispatcher->dispatch(new DynamicFormSavedContactEvent($contact, $contactData, $locale));
    }
}
