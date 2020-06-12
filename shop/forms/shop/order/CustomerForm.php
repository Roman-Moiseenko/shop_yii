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
            $this->name = $user->fullname->getFullname();
            $this->phone = $user->phone;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['phone', 'name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['phone', 'string', 'length' => 10],
            ['phone', 'match', 'pattern' => '/^[0-9]*$/i'],

        ];
    }
}