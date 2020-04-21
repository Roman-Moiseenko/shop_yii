<?php

use shop\entities\user\User;
use shop\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\entities\user\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class="box">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'password_reset_token',
            [
                'attribute' => 'status',
                'value' => function (User $user) {
                    return UserHelper::statusLabel($user->status);
                },
                'format' => 'raw',
                'label' => 'Статус',
            ],
            [
                'attribute' =>'created_at',
                'format' => 'datetime',
                'label' => 'Создан'
            ],
            [
                'attribute' =>'updated_at',
                'format' => 'datetime',
                'label' => 'Изменен'
            ],
            'verification_token',
        ],
    ]) ?>
    </div>
</div>
</div>
