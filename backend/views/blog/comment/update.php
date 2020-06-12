<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post shop\entities\blog\post\Post */
/* @var $model shop\forms\manage\blog\post\CommentEditForm */

$this->title = 'Изменить: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="post-update">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="box box-default">
        <div class="box-header with-border"></div>
        <div class="box-body">
            <?= $form->field($model, 'parentId')->textInput()->label('Родительский комментарий') ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 20])->label('Текст') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
