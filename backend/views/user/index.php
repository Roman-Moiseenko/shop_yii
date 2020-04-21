<?php

use kartik\widgets\DatePicker;
use shop\entities\user\User;
use yii\helpers\Html;
use yii\grid\GridView;
use \shop\helpers\UserHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box">
        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'username',
                'format' => 'text',
                'label' => 'Логин'
            ],
            [
                'attribute' => 'email',
                'format' => 'email',
                'label' => 'Почта'
            ],
            [
                'attribute' => 'status',
                'filter' => UserHelper::statusList(),
                'value' => function (User $user) {
                    return UserHelper::statusLabel($user->status);
                },
                'format' => 'raw',
                'label' => 'Статус',
            ],
            [
                'attribute' =>'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => [
                        'todayHighLight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
                'format' => 'datetime',
                'label' => 'Создан',
            ],
            [
                'attribute' =>'updated_at',
                'format' => 'datetime',
                'label' => 'Изменен'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        </div>
    </div>

</div>
