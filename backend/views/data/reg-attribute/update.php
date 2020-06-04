<?php

use shop\entities\shop\RegAttribute;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\forms\data\RegAttributeForm */
/* @var $reg RegAttribute*/


$this->title = 'Изменить регулярку: ' . ArrayHelper::getValue($reg, 'characteristic.name');
$this->params['breadcrumbs'][] = ['label' => 'Регулярки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $reg->id, 'url' => ['view', 'id' => $reg->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="reg-attribute-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
