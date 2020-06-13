<?php

namespace backend\forms\shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\shop\product\Review;

/**
 * ReviewSearch represents the model behind the search form of `shop\entities\shop\product\Review`.
 */
class ReviewSearch extends Review
{
    public $date_filter;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', 'product_id'], 'integer'],
            [['text'], 'safe'],
            [['date_filter'], 'date', 'format' => 'php:Y-m-d'],
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
        $query = Review::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'product_id' => $this->product_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['>=', 'created_at', $this->date_filter ? strtotime($this->date_filter . '00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_filter ? strtotime($this->date_filter . '23:59:59') : null]);

        return $dataProvider;
    }
}
