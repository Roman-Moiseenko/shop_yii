<?php


namespace console\controllers;


use shop\entities\shop\order\Status;
use shop\helpers\ParamsHelper;
use shop\services\manage\UnloaderManageService;
use yii\console\Controller;

class ClearorderController extends Controller
{


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionClear()
    {
        echo 'Начало очистки заказов' . "\n";
        $sql = 'SELECT id FROM shop_orders WHERE current_status=' .
            Status::NEW . ' AND created_at<' . (time() - (int)ParamsHelper::get('timeClearOrder') * 3600 * 24);
        $orders = \Yii::$app->db->createCommand($sql)->queryAll();
        echo 'Кол-во просроченных заказов' . count($orders) . "\n";
        foreach ($orders as $order) {
            UnloaderManageService::unloadStatus($order['id'], Status::CANCELLED_BY_CUSTOMER);
            \Yii::$app->db->createCommand('DELETE FROM shop_orders WHERE id=' . $order['id'])->execute();
           // $this->service->remove($order->id);
            echo 'Заказ №' . $order['id'] . ' удален.' . "\n";
        }
    }
}