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
    public $firstname;
    public $date_from;
    public $date_to;
    public function rules()
    {
        return [
            [['id', 'user_id', 'delivery_method_id', 'current_status'], 'integer'],
            [['payment_method', 'customer_phone', 'customer_name', 'firstname'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
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
        $query = Order::find()->alias('o')->joinWith(['user u']);

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
            'o.id' => $this->id,
            'o.delivery_method_id' => $this->delivery_method_id,
            'o.current_status' => $this->current_status,
        ]);

        $query
            ->andFilterWhere(['like', 'o.payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'o.customer_phone', $this->customer_phone])
            ->andFilterWhere(['>=', 'o.created_at', $this->date_from ? strtotime($this->date_from . '00:00:00') : null])
            ->andFilterWhere(['<=', 'o.created_at', $this->date_to ? strtotime($this->date_to . '23:59:59') : null])
            ->andFilterWhere(['like', 'u.fullname_json', $this->firstname]);

        return $dataProvider;
    }
}
