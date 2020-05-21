<?php


namespace shop\services\manage;


use shop\entities\shop\order\DeliveryData;
use shop\entities\user\User;
use shop\forms\manage\user\UserCreateForm;
use shop\forms\manage\user\UserEditForm;
use shop\forms\shop\order\DeliveryForm;
use shop\repositories\UserRepository;

class UserManageService
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }
    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->users->save($user);
        return $user;
    }

    public function update($id, UserEditForm $form): User
    {
        $user = $this->users->get($id);
        $user->edit($form->username, $form->email);
        $this->users->save($user);
        return $user;
    }

    public function setPhone($id, PhoneForm $form)
    {
        $user = $this->users->get($id);
        $user->editPhone($form->phone);
        $this->users->save($user);
        return $user;
    }

    public function setDelivery($id, DeliveryForm $form)
    {
        $user = $this->users->get($id);
        $user->editDelivery(new DeliveryData($form->town, $form->address));
        $this->users->save($user);
        return $user;
    }
}