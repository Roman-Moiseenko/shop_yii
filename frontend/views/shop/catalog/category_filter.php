<?php
/* @var $this \yii\web\View */
/* @var $category \shop\entities\shop\Category*/
/* @var $searchForm \shop\forms\Shop\Search\SearchForm */

$this->title = $category->getSeoTile();
$this->registerMetaTag(['name' => 'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $category->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
foreach ($category->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = $category->name;
$this->params['active_category'] = $category;


use frontend\widgets\CategoriesWidget;
use frontend\widgets\SearchWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<aside id="column-left" class="col-sm-3 hidden-xs">

    <!-- Виджет Категории, подкатегории -->
    <?= CategoriesWidget::widget([
        'active' => $this->params['active_category'] ?? null,
        'sub' => true,
    ]); ?>


    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['action' => ['/shop/catalog/category', 'id' => $category->id], 'method' => 'get']) ?>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($searchForm, 'brand')->dropDownList($searchForm->brandsList(), ['prompt' => ''])->label('Бренд') ?>
                </div>
            </div>

            <?php foreach ($searchForm->values as $i => $value): ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php $text =''; if ($value->isAttributeSafe('from') && $value->isAttributeSafe('to')) {$text = ' (введите диапазон)';} ?>
                        <?= Html::encode($value->getCharacteristicName() . $text) ?>
                    </div>
                </div>
                <div class="row">
                    <?php if ($variants = $value->variantsList()): ?>
                        <div class="col-md-12">
                            <?= $form->field($value, '[' . $i . ']equal')->dropDownList($variants, ['prompt' => ''])->label(false) ?>
                        </div>
                    <?php elseif ($value->isAttributeSafe('from') && $value->isAttributeSafe('to')): ?>
                        <div class="col-md-6">
                            <?= $form->field($value, '[' . $i . ']from')->textInput()->label(false)  ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($value, '[' . $i . ']to')->textInput()->label(false)  ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach; ?>

            <div class="row">
                <div class="col-md-12">
                    <?= Html::submitButton('Показать', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</aside>
<div id="content" class="col-sm-9">
<h1><?=Html::encode($category->getHeadingTile())?></h1>
<hr/>
<?= $this->render('_subcategories', ['category' =>$category]); ?>
<?php if ($category->description):?>
<div class="card">
    <div class="card-body">
        <?=Yii::$app->formatter->asNtext($category->description);?>
    </div>
</div>
<?php endif;?>
<?= $this->render('_list', ['dataProvider' => $dataProvider]); ?>
</div>