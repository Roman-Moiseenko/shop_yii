<?php

namespace backend\forms\shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\shop\product\Product;

/**
 * ProductSearch represents the model behind the search form of `shop\entities\shop\product\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'brand_id', 'created_at', 'price_old', 'price_new'], 'integer'],
            [['code', 'name', 'meta_json', 'code1C'], 'safe'],
            [['rating'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'created_at' => $this->created_at,
            'price_old' => $this->price_old,
            'price_new' => $this->price_new,
            'rating' => $this->rating,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'meta_json', $this->meta_json])
            ->andFilterWhere(['like', 'code1C', $this->code1C]);

        return $dataProvider;
    }
}
