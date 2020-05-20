<?php


namespace shop\entities\shop\order;


class CustomerData
{
    public $name;
    public $phone;

    public function __construct($phone, $name)
    {
        $this->phone = $phone;
        $this->name = $name;
    }

}