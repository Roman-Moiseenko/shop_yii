<?php

/* @var $this yii\web\View */
/* @var $user \shop\entities\user\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['reset/verify-email', 'token' => $user->verification_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
