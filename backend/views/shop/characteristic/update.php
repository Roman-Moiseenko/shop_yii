<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $characteristic shop\entities\shop\Characteristic */

$this->title = 'Редактировать Атрибут: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $characteristic->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="characteristic-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
