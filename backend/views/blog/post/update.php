<?php

use shop\forms\manage\blog\Post\PostForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post shop\entities\blog\post\Post */
/* @var $model PostForm */


$this->title = 'Редактировать Пост: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="post-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
