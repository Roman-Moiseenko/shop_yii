<?php

use shop\helpers\PostHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post shop\entities\blog\post\Post */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?php if ($post->isActive()): ?>
            <?= Html::a('Снять', ['draft', 'id' => $post->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Опубликовать', ['activate', 'id' => $post->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Изменить', ['update', 'id' => $post->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $post->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Общие</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $post,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'status',
                        'value' => PostHelper::statusLabel($post->status),
                        'format' => 'raw',
                        'label' => 'Статус',
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Заголовок',
                    ],
                    [
                        'attribute' => 'category_id',
                        'value' => ArrayHelper::getValue($post, 'category.name'),
                        'label' => 'Категория',
                    ],
                    [
                        'label' => 'Теги',
                        'value' => implode(', ', ArrayHelper::getColumn($post->tags, 'name')),
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Картинка</div>
        <div class="box-body">
            <?php if ($post->photo): ?>
                <?= Html::a(Html::img($post->getThumbFileUrl('photo', 'thumb')), $post->getUploadedFileUrl('photo'), [
                    'class' => 'thumbnail',
                    'target' => '_blank'
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Описание</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($post->description) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Содержимое</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($post->content, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $post,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'value' => $post->meta->title,
                    ],
                    [
                        'attribute' => 'meta.description',
                        'value' => $post->meta->description,
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'value' => $post->meta->keywords,
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>
