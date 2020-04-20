<?php


namespace shop\tests\unit\entities;


use Codeception\Test\Unit;
use shop\entities\User;

class SignupTest extends Unit
{
    public function testSuccess()
    {
        $user = User::signup(
            $username = 'Vasy',
            $email = 'mail@mail.ru',
            $password = '111111'
        );
        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertFalse( $user->isActive());
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
    }



}