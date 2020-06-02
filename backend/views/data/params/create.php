<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\entities\Params */

$this->title = 'Создать Параметр';
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="params-create">
<h1>Для теста ... параметры только через миграцию!</h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
