<?php


namespace shop\entities\shop\order;


class DeliveryData
{

    private $index;
    private $address;

    public function __construct($index, $address)
    {
        $this->index = $index;
        $this->address = $address;
    }
}