<?php


namespace shop\services\shop;

use shop\cart\Cart;
use shop\cart\CartItem;
use shop\entities\shop\order\CustomerData;
use shop\entities\shop\order\DeliveryData;
use shop\entities\shop\order\Order;
use shop\entities\shop\order\OrderItem;
use shop\entities\shop\product\Product;
use shop\entities\user\User;
use shop\forms\shop\order\OrderForm;
use shop\repositories\shop\DeliveryMethodRepository;
use shop\repositories\shop\OrderRepository;
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
    private $users;
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
        UserRepository $users,
        DeliveryMethodRepository $deliveryMethods,
        TransactionManager $transaction
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->users = $users;
        $this->deliveryMethods = $deliveryMethods;
        $this->transaction = $transaction;
    }

    public function checkout($userId, OrderForm $form)
    {
        $user = $this->users->get($userId);
        $products = [];
        $items = array_map(
            function (CartItem $item) use (&$products) {
                $product = $item->getProduct();
                $product->checkout($item->getQuantity());
                $products[] = $product;
                return OrderItem::create(
                    $product,
                    $item->getPrice(),
                    $item->getQuantity()
                );
            },
            $this->cart->getItems()
        );
        //echo'<pre>'; print_r($products); exit();
        $order = Order::create(
            $userId,
            new CustomerData(
                $form->customer->phone,
                $form->customer->name
            ),
            $items,
            $this->cart->getCost()->getTotal(),
            $form->note
        );
        $order->setDeliveryInfo(
            $this->deliveryMethods->get($form->delivery->method),
            new DeliveryData($form->delivery->town, $form->delivery->address)
        );
        $this->transaction->wrap(function () use ($order, $products, $user) {
            $this->orders->save($order);
            foreach ($products as $product) {
                $this->products->save($product);
            }
            try {
                $this->unloadTo1C($user, $order);
            } catch (\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e);
            }
            $this->cart->clear();

        });
        return $order;
    }

    private function unloadTo1C(User $user, Order $order)
    {
        $path = dirname(__DIR__, 3) . '/static/exchange/out/';
        $filename = $order->id . '.order';

#######################

        $file =$path . $filename;
        $handle = fopen($file, 'w');

        /*
        if ($user->firm <> '') {
            $firm = json_decode($user->firm, true);
            $str = implode(';', $firm);
        } else {*/

        $info_user = $user->id . ';'
                . $order->customerData->name .';'
                . $order->customerData->phone . ';'
                . $order->deliveryData->town . ',' . $order->deliveryData->address . ';'
                . $user->email;
        $info_order = $order->id.';'
            . $order->current_status . ';'
            . $order->deliveryData->town . ',' . $order->deliveryData->address . ';'
            . $order->note . ';'
            . date('YmdHis', $order->created_at) . ';'
            . $this->cart->getCost()->getPercent();
        fwrite($handle, $info_user . PHP_EOL);
        fwrite($handle, $info_order . PHP_EOL);
        foreach ($this->cart->getItems() as $cartItem)
        {
            $product = $cartItem->getProduct();
            /* @var Product $product*/
            fwrite($handle, $product->code1C . ';' . $cartItem->getQuantity() . ';' . $cartItem->getPrice() . PHP_EOL);
        }
        fclose($handle);
        return true;
    }

}