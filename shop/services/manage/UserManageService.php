<?php


namespace shop\services\manage;


use shop\entities\shop\order\DeliveryData;
use shop\entities\user\FullName;
use shop\entities\user\User;
use shop\forms\manage\user\ContactDataForm;
use shop\forms\manage\user\DeliveryProfileForm;
use shop\forms\manage\user\UserCreateForm;
use shop\forms\manage\user\UserEditForm;
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

    public function setContact($id, ContactDataForm $form)
    {
        $user = $this->users->get($id);
        $user->editPhone($form->phone);
        $user->editFullName(
            new FullName(
                $form->surname,
                $form->firstname,
                $form->secondname
            )
        );
        $this->users->save($user);
        return $user;
    }

    public function setDelivery($id, DeliveryProfileForm $form)
    {
        $user = $this->users->get($id);
        $user->editDelivery(new DeliveryData($form->town, $form->address));
        $this->users->save($user);
        return $user;
    }
}