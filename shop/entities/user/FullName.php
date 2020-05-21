<?php


namespace shop\entities\user;


class FullName
{
    public $surname;
    public $firstname;
    public $secondname;

    public function __construct($surname, $firstname, $secondname = '')
    {
        $this->surname = $surname;
        $this->firstname = $firstname;
        $this->secondname = $secondname;
    }
}