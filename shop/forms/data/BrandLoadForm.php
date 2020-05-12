<?php


namespace shop\forms\data;


use yii\base\Model;

class BrandLoadForm extends Model
{

    public $category;
    public $brand;


    public function rules()
    {
        return [
            [['category', 'brand'], 'integer'],
            [['category', 'brand'], 'required'],
        ];
    }
}