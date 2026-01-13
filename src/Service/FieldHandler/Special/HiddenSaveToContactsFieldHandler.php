<?php

namespace Linderp\SuluFormSaveContactBundle\Service\FieldHandler\Special;
use App\Repository\Newsletter\NewsletterRepository;
use Linderp\SuluFormSaveContactBundle\Service\FieldHandler\FieldHandler;
use Sulu\Bundle\CategoryBundle\Entity\Category;
use Sulu\Bundle\CategoryBundle\Entity\CategoryRepositoryInterface;

class HiddenSaveToContactsFieldHandler extends FieldHandler
{
    public function __construct(){
    }
    protected function handleField(array $field, array $data): array
    {
        if(!array_key_exists('options',$field)
            || !array_key_exists('saveToContacts',$field['options']) || !$field['options']['saveToContacts']){
            return $data;
        }
        $data[$this->getPropertyName()] = true;
        if(!array_key_exists('categoryId',$field['options']) || $field['options']['categoryId'] === null){
            return $data;
        }
        $data['categories'] = [$field['options']['categoryId']];
        return $data;
    }

    protected function getFieldType(): string
    {
        return 'hidden_save_to_contacts';
    }

    protected function getPropertyName(): string
    {
        return 'saveToContacts';
    }
}
