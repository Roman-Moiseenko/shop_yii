<?php

use shop\entities\shop\product\Review;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $reviews Review[] */
?>
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-commenting"></i>
        <span class="label label-success"><?= count($reviews) ?></span>
    </a>
    <ul class="dropdown-menu">
        <li class="header"><?= count($reviews) ?> новых отзывов</li>
        <li>
            <ul class="menu">
                <?php foreach ($reviews as $review): ?>
                    <li>
                        <a href="<?= Html::encode(Url::to(['shop/review/view', 'id' => $review->id])) ?>">
                                <i class="fa fa-commenting text-green"></i>
                            <?= StringHelper::truncate(strip_tags($review->product->name), 100); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="footer"><a href="<?= Html::encode(Url::to(['shop/review'])) ?>">Посмотреть все</a></li>
    </ul>
</li>
