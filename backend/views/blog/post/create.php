<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\entities\blog\post\Post */

$this->title = 'Создать пост';
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
