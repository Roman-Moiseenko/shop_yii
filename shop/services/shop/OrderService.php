<?php


namespace shop\services\shop;

use shop\cart\Cart;
use shop\cart\CartItem;
use shop\entities\shop\order\CustomerData;
use shop\entities\shop\order\DeliveryData;
use shop\entities\shop\order\Order;
use shop\entities\shop\order\OrderItem;
use shop\entities\shop\order\Status;
use shop\entities\shop\product\Product;
use shop\entities\user\User;
use shop\forms\shop\order\OrderForm;
use shop\repositories\shop\DeliveryMethodRepository;
use shop\repositories\shop\OrderRepository;
use shop\repositories\shop\ProductRepository;
use shop\repositories\UserRepository;
use shop\services\ContactService;
use shop\services\manage\shop\ProductManageService;
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
    /**
     * @var ContactService
     */
    private $contacts;


    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        ProductRepository $products,
        UserRepository $users,
        DeliveryMethodRepository $deliveryMethods,
        TransactionManager $transaction,
        ContactService $contacts
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->users = $users;
        $this->deliveryMethods = $deliveryMethods;
        $this->transaction = $transaction;
        $this->contacts = $contacts;
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
        $order = Order::create(
            $userId,
            new CustomerData(
                $form->customer->phone,
                $form->customer->name
            ),
            $items,
            $this->cart->getCost()->getTotal(),
            $form->note,
            $this->cart->getCost()->getOrigin(),
            $this->cart->getCost()->getPercent()
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
                Change1CService::unloadTo1C($user, $order);
            } catch (\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e);
            }
            $this->contacts->sendNoticeOrder($order);
            $this->cart->clear();
        });
        return $order;
    }

    public function remove($id)
    {
        $order = $this->orders->get($id);
        $this->transaction->wrap(function () use ($order) {
            foreach ($order->items as $orderItem) {
                $product = $orderItem->getProduct();
                $product->remains += $orderItem->quantity;
                $this->products->save($product);
            }
            $this->contacts->sendNoticeOrder($order);
            Change1CService::unloadStatus($order->id, Status::CANCELLED_BY_CUSTOMER);
            $this->orders->remove($order);
        });
    }

    public function pay($id, string $payment_method)
    {
        $order = $this->orders->get($id);
        $order->pay($payment_method);
        $this->orders->save($order);
        $this->contacts->sendNoticeOrder($order);
        Change1CService::unloadStatus($order->id, Status::PAID);
    }

    public function wait($id)
    {
        $order = $this->orders->get($id);
        $order->wait();
        $this->orders->save($order);
        $this->contacts->sendNoticeOrder($order);
    }

    public function cancel($id, string $reason)
    {
        $order = $this->orders->get($id);
        $order->cancel($reason);
        $this->orders->save($order);
        $this->contacts->sendNoticeOrder($order);
        Change1CService::unloadStatus($order->id, Status::CANCELLED);
    }

    public function complete($id)
    {
        $order = $this->orders->get($id);
        $order->complete();
        $this->orders->save($order);
        $this->contacts->sendNoticeOrder($order);
    }

}