<?php

namespace Linderp\SuluFormSaveContactBundle\Subscriber;
use Linderp\SuluFormSaveContactBundle\Service\DynamicFormHandler;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Event\FormSavePostEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class DynamicFormSubscriber implements EventSubscriberInterface
{
    public function __construct(private DynamicFormHandler $dynamicFormHandler){

    }
    public static function getSubscribedEvents(): array
    {
        return [
            FormSavePostEvent::NAME => "formFilledOut"
        ];
    }
    public function formFilledOut(FormSavePostEvent $event): void
    {
        $dynamic = $event->getData();
        if (!$dynamic instanceof Dynamic) {
            return;
        }
        $form = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);
        $this->dynamicFormHandler->saveContact($form, $dynamic->getLocale());
    }
}
