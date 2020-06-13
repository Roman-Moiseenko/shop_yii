<?php

use frontend\widgets\RatingWidget;
use shop\entities\shop\product\Review;
use shop\helpers\PostHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $review shop\entities\shop\product\Review */

$this->title = StringHelper::truncate(strip_tags($review->product->name), 30);
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="review-view">
    <p>
        <?php if ($review->isActive()): ?>
            <?= Html::a('Снять с публикации', ['draft', 'id' => $review->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Опубликовать', ['activate', 'id' => $review->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $review,
                'attributes' => [
                    [
                        'attribute' => 'product_id',
                        'label' => 'Товар',
                        'value' => Html::a($review->product->name,
                            \Yii::$app->params['frontendHostInfo'] . '/catalog/'. $review->product_id),
                        'format' => 'raw',
                    ],
                    'id',
                    [
                        'attribute' => 'created_at',
                        'label' => 'Дата',
                        'format' => 'date',
                    ],
                    [
                        'attribute' => 'user_id',
                        'label' => 'Пользователь',
                        'value' => Html::a($review->user->username, Url::to(['user/view', 'id' => $review->user_id])),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'vote',
                        'label' => 'Рейтинг',
                        'value' => RatingWidget::widget(['rating' => $review->vote]),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'active',
                        'value' => PostHelper::statusLabel($review->active),
                        'format' => 'raw',
                        'label' => 'Статус',
                    ],
                    // 'product_id',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($review->text) ?>
        </div>
    </div>
</div>
