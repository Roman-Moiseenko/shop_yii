<?php

/* @var $this yii\web\View */
/* @var $tag shop\entities\Blog\Tag */
/* @var $model shop\forms\manage\Blog\TagForm */

$this->title = 'Изменить Тег: ' . $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
