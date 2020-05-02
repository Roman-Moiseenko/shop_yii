<?php


namespace frontend\controllers\shop;


use shop\entities\shop\product\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    public function actionIndex()
    {
        // Product::find()->
        $dataProvider = new ActiveDataProvider([
                'query' => Product::find()->alias('p')->andWhere(['>', 'p.remains', 0]),
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['p.id' => SORT_ASC], 'desc' => ['p.id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['p.name' => SORT_ASC], 'desc' => ['p.name' => SORT_DESC],
                        ],
                        'price' => [
                            'asc' => ['p.price_new' => SORT_ASC], 'desc' => ['p.price_new' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['p.rating' => SORT_ASC], 'desc' => ['p.rating' => SORT_DESC],
                        ],

                    ],
                ],
            ]
        );
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

}