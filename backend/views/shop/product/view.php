<?php

use kartik\file\FileInput;
use shop\entities\Shop\Product\Modification;
use shop\entities\Shop\Product\Value;
use shop\helpers\PriceHelper;
use shop\helpers\ProductHelper;
use shop\helpers\WeightHelper;
use yii\bootstrap\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $product shop\entities\Shop\Product\Product */
/* @var $photosForm shop\forms\manage\Shop\Product\PhotosForm */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">Общие</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            'id',
                            /* [
                                 'attribute' => 'status',
                                 'value' => ProductHelper::statusLabel($product->status),
                                 'format' => 'raw',
                             ],*/
                            [
                                'label' => 'Бренд',
                                'attribute' => 'brand_id',
                                'value' => ArrayHelper::getValue($product, 'brand.name'),
                            ],
                            [
                                    'attribute' =>'code',
                                'label' => 'Артикул',
                                ],
                            [
                                'attribute' =>'name',
                                'label' => 'Товар',
                            ],
                            [
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($product, 'category.name'),
                                'label' => 'Категория',
                            ],
                            [
                                'label' => 'Дополнительные категории',
                                'value' => implode(', ', ArrayHelper::getColumn($product->categories, 'name')),
                            ],
                            [
                                'label' => 'Метки',
                                'value' => implode(', ', ArrayHelper::getColumn($product->tags, 'name')),
                            ],
                            /* 'quantity',
                             [
                                 'attribute' => 'weight',
                                 'value' => WeightHelper::format($product->weight),
                             ],*/
                            [
                                'attribute' => 'price_new',
                                'value' => PriceHelper::format($product->price_new),
                                'format' => 'raw',
                                'label' => 'Цена новая',
                            ],
                            [
                                'attribute' => 'price_old',
                                'value' => PriceHelper::format($product->price_old),
                                'format' => 'raw',
                                'label' => 'Цена предыдущая',
                            ],
                            [
                                'attribute' => 'units',
                                'label' => 'Ед.изм.',
                            ],
                            [
                                'attribute' => 'code1C',
                                'label' => 'Код в 1С',
                            ],
                        ],
                    ]) ?>
                    <br/>
                    <p>
                        <?= Html::a('Изменить цену', ['price', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="box box-default">
                <div class="box-header with-border">Характеристики</div>
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => array_map(function (Value $value) {
                            return [
                                'label' => $value->characteristic->name,
                                'value' => $value->value,
                            ];
                        }, $product->values),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Описание</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($product->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>

    <div class="box" id="modifications">
        <div class="box-header with-border">Модификации</div>
        <div class="box-body">
            <p>
                <?= Html::a('Добавить Модификацию', ['shop/modification/create', 'product_id' => $product->id], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $modificationsProvider,
                'columns' => [
                    [
                        'attribute' =>'code',
                        'label' => 'Артикул',
                        ],
                    [
                        'attribute' =>'name',
                        'label' => 'Наименование',
                    ],
                    [
                        'attribute' => 'price',
                        'value' => function (Modification $model) {
                            return PriceHelper::format($model->price);
                        },
                        'format' => 'raw',
                        'label' => 'Цена',
                    ],
                    /*'quantity',*/
                    [
                        'class' => ActionColumn::class,
                        'controller' => 'shop/modification',
                        'template' => '{update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Для SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $product,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'value' => $product->meta->title,
                        'label' => 'Заголовок',
                    ],
                    [
                        'attribute' => 'meta.description',
                        'value' => $product->meta->description,
                        'label' => 'Описание',
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'value' => $product->meta->keywords,
                        'label' => 'Ключевые слова',
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box" id="photos">
        <div class="box-header with-border">Фотографии</div>
        <div class="box-body">

            <div class="row">
                <?php foreach ($product->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <?= Html::a(
                                Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                $photo->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

            <?= $form->field($photosForm, 'files[]')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
