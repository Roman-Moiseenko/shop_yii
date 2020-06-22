<?php


namespace shop\services\manage;


use shop\entities\shop\order\Order;
use shop\entities\shop\product\Product;
use shop\entities\user\User;
use shop\services\ContactService;

class UnloaderManageService
{
    public static function unloadTo1C(User $user, Order $order)
    {
        $path = dirname(__DIR__, 3) . '/static/exchange/out/';
        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $filename = $order->id . '.order';
        $file = $path . $filename;
        $handle = fopen($file, 'w');

        $info_user = $user->id . ';'
            . $order->customerData->name .';'
            . $order->customerData->phone . ';'
            . $order->deliveryData->town . ',' . $order->deliveryData->address . ';'
            . $user->email;
        $info_order = $order->id.';'
            . $order->current_status . ';'
            . $order->delivery_cost . ';'
            . $order->note . ';'
            . date('YmdHis', $order->created_at) . ';'
            . $order->discount;
        fwrite($handle, $info_user . PHP_EOL);
        fwrite($handle, $info_order . PHP_EOL);
        foreach ($order->items as $orderItem)
        {
            $product = $orderItem->getProduct();
            /* @var Product $product*/
            fwrite($handle, $product->code1C . ';' . $orderItem->quantity . ';' . $orderItem->price . PHP_EOL);
        }
        fclose($handle);
        return true;
    }

    public static function unloadStatus($order_id, $status)
    {
        $path = dirname(__DIR__, 3) . '/static/exchange/out/';
        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $filename = $order_id . '.status';
        $file = $path . $filename;
        $handle = fopen($file, 'w');
        $info_order = $order_id.';'
            . $status;
        fwrite($handle, $info_order . PHP_EOL);
        fclose($handle);
        return true;
    }

}