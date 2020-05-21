<?php


namespace shop\forms\manage\user;


use yii\base\Model;

class FullNameForm extends Model
{
    public $surname;
    public $firstname;
    public $secondname;

    public function rules()
    {
        return [
            [['surname', 'firstname', 'secondname'], 'string', 'max' => 33],
            [['surname', 'firstname'], 'required'],
        ];
    }

}