<?php


namespace frontend\widgets;


use shop\cart\Cart;
use shop\services\shop\CartService;
use yii\base\Widget;

class CartWidget extends Widget
{

    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart, $config = [])
    {
        parent::__construct($config);
        $this->cart = $cart;
    }

    public function run()
    {
        return $this->render('cart', [
           'cart' => $this->cart
        ]);
    }
}