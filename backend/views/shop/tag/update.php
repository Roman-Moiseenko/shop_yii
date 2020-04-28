<?php

/* @var $this yii\web\View */
/* @var $tag shop\entities\Shop\Tag */
/* @var $model shop\forms\manage\Shop\TagsForm */

$this->title = 'Редактирование метки: ' . $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Метки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>