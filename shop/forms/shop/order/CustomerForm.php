<?php


namespace shop\forms\shop\order;


use yii\base\Model;

class CustomerForm extends Model
{
    public $name;
    public $phone;

    public function rules()
    {
        return [
            [['phone', 'name'], 'required'],
            [['phone', 'name'], 'string', 'max' => 255],
        ];
    }
}