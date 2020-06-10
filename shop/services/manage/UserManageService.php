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
use shop\services\RoleManager;
use shop\services\TransactionManager;

class UserManageService
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var RoleManager
     */
    private $roles;
    /**
     * @var TransactionManager
     */
    private $transaction;

    public function __construct(UserRepository $users, RoleManager $roles, TransactionManager $transaction)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );

       $this->transaction->wrap(function () use($user, $form) {
            $this->users->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        return $user;
    }

    public function update($id, UserEditForm $form): User
    {
        $user = $this->users->get($id);
        $user->edit($form->username, $form->email);
        $this->transaction->wrap(function () use($user, $form) {
            if (!empty($form->password)) $user->setPassword($form->password);
            $this->users->save($user);
            $this->roles->assign($user->id, $form->role);
        });

        return $user;
    }

    public function setContact($id, ContactDataForm $form)
    {
        $user = $this->users->get($id);
        $user->editPhone($form->phone);


        $user->editFullName(
            new FullName(
                $this->ExcangeName($form->surname),
                $this->ExcangeName($form->firstname),
                $this->ExcangeName($form->secondname)
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

    private function ExcangeName($name): string
    {
        $name = mb_strtolower($name);
        return mb_strtoupper(mb_substr($name, 0, 1)) . mb_substr($name, 1, mb_strlen($name) - 1);
    }

}