<?php

namespace Linderp\SuluFormSaveContactBundle\Service;

use Linderp\SuluFormSaveContactBundle\Event\DynamicFormSavedContactEvent;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\ContactAlreadyExistsException;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Exception\FieldException;
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

    /**
     * @throws FieldException
     */
    private function hasSaveContactField(array $form):bool
    {
        foreach ($form['fields'] as $field) {
            if($this->hiddenSaveToContactsFieldHandler->match($field)){
                return $this->hiddenSaveToContactsFieldHandler->handle($field,[])[HiddenSaveToContactsFieldHandler::getPropertyName()];
            }
        }
        return false;
    }

    public function saveContact(array $form, string $locale):void
    {
        try {
            if (!$this->hasSaveContactField($form)) {
                return;
            }
        } catch (FieldException $e) {
            return;
        }
        $contactData = ['lastName' => ''];
        $existingContact = null;
        foreach ($form['fields'] as $field) {
            foreach ($this->fieldHandlers as $fieldHandler){
                if(!$fieldHandler->match($field)){
                    continue;
                }
                try {
                    $contactData = $fieldHandler->handle($field, $contactData);
                } catch (FieldException $e) {
                    if($e instanceof ContactAlreadyExistsException){
                        $existingContact = $e->getContact();
                    }
                    continue;
                }
            }
        }
        $contact = $existingContact ?? $this->contactManager->save(
            $contactData
        );
        $this->eventDispatcher->dispatch(new DynamicFormSavedContactEvent($contact, $contactData, $locale,
            $existingContact !== null));
    }
}
