<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\RegAttribute */

$this->title = 'Создать регулярку';
$this->params['breadcrumbs'][] = ['label' => 'Регулярка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reg-attribute-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
