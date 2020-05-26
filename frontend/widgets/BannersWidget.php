<?php


namespace frontend\widgets;


use yii\base\Widget;
use yii\helpers\Url;

class BannersWidget extends Widget
{
    public function run()
    {
        $banners = [];
        $path = dirname(__DIR__, 2) . '/static/banners/';
        //считываем картинки
        $files = glob($path .'*.jpg');
        $banners = array_map(function (string $file) {
            return Url::to('@static/banners/' . basename($file));
        }, $files);
        //массивом передаем во вьюшку
        return $this->render('banners', [
            'banners' => $banners,
        ]);
    }
}