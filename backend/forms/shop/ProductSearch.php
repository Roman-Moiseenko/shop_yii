<?php

namespace backend\forms\shop;

use shop\entities\shop\Brand;
use shop\entities\shop\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\shop\product\Product;
use yii\helpers\ArrayHelper;

/**
 * ProductSearch represents the model behind the search form of `shop\entities\shop\product\Product`.
 */
class ProductSearch extends Product
{
    public $notRemains = false;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'brand_id'], 'integer'],
            [['code', 'name', 'code1C'], 'safe'],
            [['featured'], 'boolean'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find()->with('category'); //'mainPhoto',

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'featured' => $this->featured,

        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code1C', $this->code1C])
            ->andFilterWhere(['>', 'remains', $this->notRemains ? 0 : null]);

        return $dataProvider;
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->
        orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ?
                        str_repeat('--', $category['depth'] - 1) . ' ' : '') . $category['name'];
            }
        );
    }

    public function brandList(): array
    {
        return ArrayHelper::map(Brand::find()->orderBy('id')->asArray()->all(),
            'id',
            function (array $brand) {
                return $brand['name'];
            }
        );
    }
    public function featured()
    {
        return [false => 'Нет', true => 'Да'];
    }
}
