<?php

namespace shop\forms\manage\user;

use shop\entities\user\User;
use yii\base\Model;

class DeliveryProfileForm extends Model
{
    public $town;
    public $address;

    public function __construct(User $user, $config = [])
    {
        $this->town = $user->deliveryData->town;
        $this->address = $user->deliveryData->address;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['town', 'address'], 'string'],
            [['address'], 'required'],
        ];
    }

}