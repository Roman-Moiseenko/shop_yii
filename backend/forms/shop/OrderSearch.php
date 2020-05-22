<?php

namespace backend\forms\shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\shop\order\Order;

/**
 * OrderSearch represents the model behind the search form of `shop\entities\shop\order\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'user_id', 'delivery_method_id', 'delivery_cost', 'cost', 'current_status'], 'integer'],
            [['delivery_method_name', 'payment_method', 'note', 'cancel_reason', 'statuses_json', 'customer_phone', 'customer_name', 'delivery_town', 'delivery_address'], 'safe'],
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
        $query = Order::find();

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
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'delivery_method_id' => $this->delivery_method_id,
            'delivery_cost' => $this->delivery_cost,
            'cost' => $this->cost,
            'current_status' => $this->current_status,
        ]);

        $query->andFilterWhere(['like', 'delivery_method_name', $this->delivery_method_name])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason])
            ->andFilterWhere(['like', 'statuses_json', $this->statuses_json])
            ->andFilterWhere(['like', 'customer_phone', $this->customer_phone])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'delivery_town', $this->delivery_town])
            ->andFilterWhere(['like', 'delivery_address', $this->delivery_address]);

        return $dataProvider;
    }
}
