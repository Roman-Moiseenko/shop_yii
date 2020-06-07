<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post shop\entities\blog\post\Post */
/* @var $comment shop\entities\blog\post\Comment */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">
    <p>
        <?= Html::a('Изменить', ['update', 'post_id' => $post->id, 'id' => $comment->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($comment->isActive()): ?>
            <?= Html::a('Удалить', ['delete', 'post_id' => $post->id, 'id' => $comment->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Удалить Комментарий?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php else: ?>
            <?= Html::a('Активировать', ['activate', 'post_id' => $post->id, 'id' => $comment->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Активировать Комментарий?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $comment,
                'attributes' => [
                    'id',
                    'created_at:boolean',
                    'active:boolean',
                    'user_id',
                    'parent_id',
                    [
                        'attribute' => 'post_id',
                        'value' => $post->title,
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($comment->text) ?>
        </div>
    </div>
</div>