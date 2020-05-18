<?php

namespace backend\forms\Shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\shop\discount\Discount;

/**
 * DiscountSearch represents the model behind the search form of `shop\entities\shop\discount\Discount`.
 */
class DiscountSearch extends Discount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percent', 'active'], 'integer'],
            [['type_class'], 'safe'],
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
        $query = Discount::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'percent' => $this->percent,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'type_class', $this->type_class]);

        return $dataProvider;
    }
}
