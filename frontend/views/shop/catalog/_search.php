<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $searchForm \shop\forms\Shop\Search\SearchForm */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-body">
<?php $form = ActiveForm::begin(['action' => ['/shop/catalog/search'], 'method' => 'get']) ?>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($searchForm, 'text')->textInput()->label('Товар (имя или код)') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($searchForm, 'category')->dropDownList($searchForm->categoriesList(), ['prompt' => '', 'class' => 'change-attr form-control'])->label('Категория')?>
    </div>
    <div class="col-md-4">
        <?= $form->field($searchForm, 'brand')->dropDownList($searchForm->brandsList(), ['prompt' => ''])->label('Бренд') ?>
    </div>
</div>

<?php foreach ($searchForm->values as $i => $value): ?>
    <div class="row">
        <div class="col-md-4">
            <?php $text =''; if ($value->isAttributeSafe('from') && $value->isAttributeSafe('to')) {$text = ' (введите диапазон)';} ?>
            <?= Html::encode($value->getCharacteristicName() . $text) ?>
        </div>
        <?php if ($variants = $value->variantsList()): ?>
            <div class="col-md-4">
                <?= $form->field($value, '[' . $i . ']equal')->dropDownList($variants, ['prompt' => ''])->label(false) ?>
            </div>
        <?php elseif ($value->isAttributeSafe('from') && $value->isAttributeSafe('to')): ?>
            <div class="col-md-2">
                <?= $form->field($value, '[' . $i . ']from')->textInput()->label(false)  ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($value, '[' . $i . ']to')->textInput()->label(false)  ?>
            </div>
        <?php endif ?>
    </div>
<?php endforeach; ?>

<div class="row">
    <div class="col-md-6">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
    </div>
    <div class="col-md-6">
        <?= Html::a('Очистить', [''], ['class' => 'btn btn-default btn-lg btn-block']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>

    </div>
</div>