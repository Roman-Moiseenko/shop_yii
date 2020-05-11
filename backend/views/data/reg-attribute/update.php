<?php

use shop\entities\shop\RegAttribute;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\forms\data\RegAttributeForm */
/* @var $reg RegAttribute*/

$this->title = 'Update Reg Attribute: ' . $reg->id;
$this->params['breadcrumbs'][] = ['label' => 'Регулярки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $reg->id, 'url' => ['view', 'id' => $reg->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="reg-attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
