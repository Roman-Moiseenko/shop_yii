<?php


namespace shop\entities\shop\order;


class DeliveryData
{

    public $town;
    public $address;

    public function __construct($town, $address)
    {
        $this->town = $town;
        $this->address = $address;
    }
}