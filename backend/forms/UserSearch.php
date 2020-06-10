<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\user\User;

/**
 * UserSearch represents the model behind the search form of `shop\entities\user\User`.
 */
class UserSearch extends Model
{
    /**
     * {@inheritdoc}
     */
    public $id;
    public $status;
    public $date_from;
    public $date_to;
    public $username;
    public $email;
    public $role;

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'role'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
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
        $query = User::find()->alias('u');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {

            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.status' => $this->status,
            //'role'
        ]);

        if (!empty($this->role)) {
            $query->innerJoin('{{%auth_assignments}} a', 'a.user_id = u.id');
            $query->andWhere(['a.item_name' => $this->role]);
        }
        $query
            ->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email])
            ->andFilterWhere(['>=', 'u.created_at', $this->date_from ? strtotime($this->date_from . '00:00:00') : null])
            ->andFilterWhere(['<=', 'u.created_at', $this->date_to ? strtotime($this->date_to . '23:59:59') : null]);

        return $dataProvider;
    }
}
