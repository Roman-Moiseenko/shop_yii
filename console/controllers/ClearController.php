<?php


namespace console\controllers;


use shop\entities\shop\loaddata\File;
use shop\entities\shop\order\Status;
use shop\helpers\ParamsHelper;
use shop\services\manage\FileManageService;
use shop\services\manage\UnloaderManageService;
use yii\console\Controller;

class ClearController extends Controller
{


    /**
     * @var FileManageService
     */
    private $files;

    public function __construct($id, $module, FileManageService $files, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->files = $files;
    }

    public function actionOrders()
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

    public function actionFiles()
    {
        echo 'Начало очистки файлов' . "\n";
        $files = File::find()->andWhere(['<=', 'created_at', time() - 3600 * 24 * 30])->all();
        foreach ($files as $file) {
            echo 'Удалем данные по файлу: ' . $file->file_name;
            $this->files->remove($file->id);
        }

    }
}