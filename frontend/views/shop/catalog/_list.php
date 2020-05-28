<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager; ?>

<div class="row">
    <div class="col-md-3 col-sm-6 hidden-xs">
        <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="Списком"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="Сеткой"><i class="fa fa-th"></i></button>
        </div>
    </div>
    <div class="col-md-6 col-xs-7">
        <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-sort">Сортировать:</label>
            <select id="input-sort" class="form-control" onchange="location = this.value;">
                <?php
                $values = [
                    '' => 'по умолчанию',
                    'name' => 'по имени (А-Я)',
                    '-name' => 'по имени (Я-А)',
                    'price' => 'по цене (сначала дешевле)',
                    '-price' => 'по цене (сначала дороже)',
                    'rating' => 'по рейтингу (высокий рейтинг)',
                    '-rating' => 'по рейтингу (низкий рейтинг)',
                ];
                $current = Yii::$app->request->get('sort');
                ?>
                <?php foreach ($values as $value => $label): ?>
                    <option value="<?=Html::encode(Url::current(['sort' => $value ?: null]))?>"
                            <?php if ($value === $current):?>selected="selected"<?php endif; ?>><?=$label?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div class="col-md-3 col-xs-5">
        <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-limit">Показать:</label>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
                <?php
                $values = [15, 25, 50, 75, 100];
                $current = $dataProvider->getPagination()->getPageSize();
                ?>
                <?php foreach ($values as $value): ?>
                    <option value="<?=Html::encode(Url::current(['per-page' => $value ?: null]))?>"
                            <?php if ($value === $current):?>selected="selected"<?php endif; ?>><?=$value?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <?php foreach ($dataProvider->getModels() as $product): ?>
        <?= $this->render('_product', [
            'product' => $product
        ]) ?>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col-sm-6 text-left">
        <?=LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ])?>
    </div>
    <div class="col-sm-6 text-right">Показано <?= $dataProvider->getCount()?> из <?= $dataProvider->getTotalCount()?></div>
</div>

