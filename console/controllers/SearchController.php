<?php


namespace console\controllers;




use shop\entities\shop\product\Product;
use yii\console\Controller;

class SearchController extends Controller
{
    public function actionReindex()
    {
        $query = Product::find()/*->NotEmpty()*/->active()
            ->with(['category', 'tagAssignments', 'values'])
            ->orderBy('id');
        $this->stdout('Очистка' . PHP_EOL);

        /**
         * Очистка индексов поисковой системы
         *
         * Создание индексов в системе поиска
         */

        foreach ($query->each() as $product) {


        }
    }

}