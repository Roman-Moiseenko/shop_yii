<?php


namespace console\controllers;


use shop\services\manage\LoaderManageService;
use yii\console\Controller;

class LoaddataController extends Controller
{

    /**
     * @var LoaderManageService
     */
    private $service;

    public function __construct($id, $module, LoaderManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionCatalog()
    {
        echo 'Начало загрузки' . "\n";
        $path = dirname(__DIR__, 2) . '/static/exchange/in/';
        $loadcatalog = glob($path . '*.groups'); //Группы товаров
        foreach ($loadcatalog as $item) {
            $this->service->loadCategory($path, basename($item));
            echo 'Файл -> ' . $item . "\n";
        }
        echo 'Конец загрузки' . "\n";
    }
    public function actionProduct()
    {
        echo 'Начало загрузки' . "\n";
        $path = dirname(__DIR__, 2) . '/static/exchange/in/';
        $loadcatalog = glob($path . '*.goods'); //Товары
        foreach ($loadcatalog as $item) {
            $this->service->loadProducts($path, basename($item));
            echo 'Файл -> ' . $item . "\n";
        }
        echo 'Конец загрузки' . "\n";
    }

    public function actionOrder()
    {
        echo 'Начало загрузки' . "\n";
        $path = dirname(__DIR__, 2) . '/static/exchange/in/';
        $loadcatalog = glob($path . '*.order'); //Заказы
        foreach ($loadcatalog as $item) {
            $this->service->loadOrder($path, basename($item));
            echo 'Файл -> ' . $item . "\n";
        }
        echo 'Конец загрузки' . "\n";
    }

    public function actionAll()
    {
        echo 'ЗАГРУЗКА КАТАЛОГОВ' . "\n";
        $this->actionCatalog();
        echo 'ЗАГРУЗКА ТОВАРОВ' . "\n";
        $this->actionProduct();
        echo 'ЗАГРУЗКА ЗАКАЗОВ' . "\n";
        $this->actionOrder();
    }
}