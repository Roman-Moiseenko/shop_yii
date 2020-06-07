<?php

namespace backend\forms\blog;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\blog\post\Comment;

/**
 * CommentSearch represents the model behind the search form of `shop\entities\blog\post\Comment`.
 */
class CommentSearch extends Comment
{
    public $id;
    public $text;
    public $active;
    public $post_id;

    public function rules(): array
    {
        return [
            [['id', 'post_id'], 'integer'],
            [['text'], 'safe'],
            [['active'], 'boolean'],
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
        $query = Comment::find()->with(['post']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'key' => function (Comment $comment) {
                return [
                    'post_id' => $comment->post_id,
                    'id' => $comment->id,
                ];
            },
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'post_id' => $this->post_id,
        ]);
        $query
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
    public function activeList(): array
    {
        return [
            1 => \Yii::$app->formatter->asBoolean(true),
            0 => \Yii::$app->formatter->asBoolean(false),
        ];
    }
}
