<?php


namespace shop\services\cabinet;


use shop\repositories\shop\ProductRepository;
use shop\repositories\UserRepository;

class WishlistService
{
    private $users;
    private $products;

    public function __construct(UserRepository $users, ProductRepository $products)
    {
        $this->users = $users;
        $this->products = $products;
    }

    public function add($user_id, $product_id):void
    {
        $user = $this->users->get($user_id);
        $product = $this->products->get($product_id);
        $user->addToWishlist($product->id);
        $this->users->save($user);
    }


    public function remove($user_id, $product_id):void
    {
        $user = $this->users->get($user_id);
        $product = $this->products->get($product_id);
        $user->removeFromWishlist($product->id);
        $this->users->save($user);
    }
}