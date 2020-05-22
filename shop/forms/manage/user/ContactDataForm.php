<?php


namespace shop\forms\manage\user;


use shop\entities\user\User;
use yii\base\Model;

class ContactDataForm extends Model
{
    public $phone;
    public $surname;
    public $firstname;
    public $secondname;

    public function __construct(User $user = null, $config = [])
    {
        if ($user) {
            $this->phone = $user->phone;
            $this->surname = $user->fullname->surname;
            $this->firstname = $user->fullname->firstname;
            $this->secondname = $user->fullname->secondname;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['phone'], 'string', 'max' => 15],
            [['surname', 'firstname', 'secondname'], 'string', 'max' => 33],
            [['surname', 'firstname', 'phone'], 'required'],
        ];
    }

}