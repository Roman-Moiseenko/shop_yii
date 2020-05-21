<?php


namespace shop\forms\shop\order;


use shop\entities\user\User;
use yii\base\Model;

class CustomerForm extends Model
{
    public $name;
    public $phone;
    public function __construct($userId = null, $config = [])
    {
        if ($userId) {
            $user = User::findOne($userId);
            //TODO сделать заполнение данных с таблицы Users
            $this->name = $user->username;

        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['phone', 'name'], 'required'],
            [['phone', 'name'], 'string', 'max' => 255],
        ];
    }
}