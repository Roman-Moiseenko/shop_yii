<?php


namespace shop\forms\manage\user;


use yii\base\Model;

class PhoneForm extends Model
{
    public $phone;

    public function rules()
    {
        return [
            [['phone'], 'string'],
        ];
    }

}