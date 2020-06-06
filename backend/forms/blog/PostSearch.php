<?php

namespace backend\forms\blog;

use shop\entities\blog\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\blog\post\Post;
use yii\helpers\ArrayHelper;

/**
 * PostSearch represents the model behind the search form of `shop\entities\blog\post\Post`.
 */
class PostSearch extends Post
{
    public $date_filter;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'created_at', 'status'], 'integer'],
            [['title'], 'safe'],
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
        $query = Post::find();

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
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
        ->andFilterWhere(['>=', 'created_at', $this->date_filter ? strtotime($this->date_filter . '00:00:00') : null])
        ->andFilterWhere(['<=', 'created_at', $this->date_filter ? strtotime($this->date_filter . '23:59:59') : null]);

        return $dataProvider;
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(),
            'id', 'name');
    }

}
