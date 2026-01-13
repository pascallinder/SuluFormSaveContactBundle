<?php

namespace Linderp\SuluFormSaveContactBundle\Subscriber;
use Sulu\Bundle\FormBundle\Event\DynFormSavedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class DynamicFormSubscriber implements EventSubscriberInterface
{
    public function __construct(){

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
    }
}
