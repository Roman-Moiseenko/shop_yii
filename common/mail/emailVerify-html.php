<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \shop\entities\user\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['reset/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to verify your email:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
