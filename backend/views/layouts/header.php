<?php

use backend\widgets\OrderHeaderWidget;
use backend\widgets\ReviewHeaderWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?= ReviewHeaderWidget::widget() ?>
                <?= OrderHeaderWidget::widget() ?>
                <li class="user user-menu">
                    <a href="<?= Html::encode(Url::to(['auth/logout'])) ?>" data-method="post">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
