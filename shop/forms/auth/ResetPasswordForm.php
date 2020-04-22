<?php
namespace shop\forms\auth;

use shop\entities\user\User;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password'], 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }

}
