<?php

use frontend\widgets\RatingWidget;
use shop\entities\shop\product\Review;
/* @var $reviews Review[] */
?>

<?php foreach ($reviews as $review): ?>
<div class="panel panel-default">
    <div class="panel-heading" style="height: 36px">
        <div class="pull-left">
            <?= $review->user->username; ?>
        </div>
        <div class="pull-right">
            <?= Yii::$app->formatter->asDatetime($review->created_at) ?>
        </div>

    </div>
    <div class="panel-body">
        <p class="comment-content">
            <?= $review->text ?>
        </p>
        <div>
            <div class="pull-left">

            </div>
            <div class="pull-right rating">
                <?= RatingWidget::widget(['rating' => $review->vote])?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>