<?php

namespace Linderp\SuluFormSaveContactBundle\Subscriber;
use Linderp\SuluFormSaveContactBundle\Service\DynamicFormHandler;
use Sulu\Bundle\FormBundle\Event\DynFormSavedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class DynamicFormSubscriber implements EventSubscriberInterface
{
    public function __construct(private DynamicFormHandler $dynamicFormHandler){

    }
    public static function getSubscribedEvents(): array
    {
        return [
            DynFormSavedEvent::NAME => "formFilledOut"
        ];
    }
    public function formFilledOut(DynFormSavedEvent $event){
        $dynamic = $event->getDynamic();
        $form = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);
        $this->dynamicFormHandler->saveContact($form, $dynamic->getLocale());
    }
}
