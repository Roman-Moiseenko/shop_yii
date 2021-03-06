<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $category shop\entities\shop\Category */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $category->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $category->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить данную категорию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-header with-border">Общие</div>
        <div class="box-body">
    <?= DetailView::widget([
        'model' => $category,
        'attributes' => [
            'id',
            [
                'attribute' => 'name',
                'format' => 'text',
                'label' => 'Категоря'
            ],
            [
                'attribute' => 'slug',
                'format' => 'text',
                'label' => 'Ссылка'
            ],
            [
                'attribute' => 'title',
                'format' => 'text',
                'label' => 'Заголовок'
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => 'Описание'
            ],
        ],
    ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Описание</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($category->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Для SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $category,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'format' => 'text',
                        'label' => 'Заголовок'
                    ],
                    [
                        'attribute' => 'meta.description',
                        'format' => 'ntext',
                        'label' => 'Описание'
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'format' => 'text',
                        'label' => 'Ключевые слова'
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
