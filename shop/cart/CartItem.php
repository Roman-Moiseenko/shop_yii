<?php


namespace shop\cart;


use shop\entities\shop\product\Product;

class CartItem
{
    private $product;
    private $quantity;
    public function __construct($product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return md5(serialize([$this->product->id]));
    }
    public function getProductId(): int
    {
        return $this->product->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity()//: int
    {
        return $this->quantity;
    }

    public function getCost(): int
    {
        return $this->getPrice() * $this->quantity;
    }
    public function getPrice(): float
    {
        return $this->product->price_new;
    }

    public function plus($quantity)
    {
        return new static($this->product, $this->quantity + $quantity);
    }
    public function sub($quantity):? self
    {
        return ($this->quantity > $quantity) ? new static($this->product, $this->quantity - $quantity) : null;
    }
    public function set($quantity)
    {
        return new static($this->product, $quantity);
    }
}