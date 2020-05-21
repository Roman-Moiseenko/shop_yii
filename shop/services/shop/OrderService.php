<?php


namespace shop\services\shop;


use shop\cart\Cart;
use shop\repositories\shop\DeliveryMethodRepository;
use shop\repositories\shop\ProductRepository;
use shop\repositories\UserRepository;
use shop\services\TransactionManager;

class OrderService
{

    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var DeliveryMethodRepository
     */
    private $deliveryMethods;
    /**
     * @var TransactionManager
     */
    private $transaction;

    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        ProductRepository $products,
        UserRepository $user,
        DeliveryMethodRepository $deliveryMethods,
        TransactionManager $transaction
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->user = $user;
        $this->deliveryMethods = $deliveryMethods;
        $this->transaction = $transaction;
    }


}