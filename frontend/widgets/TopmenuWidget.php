<?php


namespace frontend\widgets;


use shop\cart\Cart;
use shop\entities\user\WishlistItem;
use shop\helpers\WishlistHelper;
use yii\base\Widget;

class TopmenuWidget extends Widget
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
        if (\Yii::$app->user->isGuest) {
            $wishlist = 0;
        } else {
            $wishlist = WishlistItem::find()->andWhere(['user_id' => \Yii::$app->user->id])->orderBy('user_id')->count();
        }
        $cart = count($this->cart->getItems());
        return $this->render('topmenu', [
            'cart' => $cart,
            'wishlist' => $wishlist,
        ]);
    }
}