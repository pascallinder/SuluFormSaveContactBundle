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
        $data[self::getPropertyName()] = true;
        if(array_key_exists('categoryId',$field['options']) && $field['options']['categoryId'] !== null){
            $data['categories'] = [$field['options']['categoryId']];
        }
        if(array_key_exists('defaultFormOfAddress',$field['options']) && $field['options']['defaultFormOfAddress'] !== null){
            $data['formOfAddress'] = $field['options']['defaultFormOfAddress'];
        }
        return $data;
    }

    protected function getFieldType(): string
    {
        return 'hidden_save_to_contacts';
    }

    public static function getPropertyName(): string
    {
        return 'saveToContacts';
    }
}
