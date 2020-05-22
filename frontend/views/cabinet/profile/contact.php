<?php

use shop\entities\user\User;
use shop\forms\manage\user\UserEditForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model UserEditForm */
/* @var $user User */


$this->title = 'Контактные данные';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => $user->id]) ?>

<div class="panel panel-default">
    <div class="panel-heading"><h2><?= Html::encode($this->title) ?></h2></div>
    <div class="panel-body">
        <?= $form->field($model, 'surname')->textInput(['autofocus' => true])->label('Фамилия') ?>
        <?= $form->field($model, 'firstname')->textInput()->label('Имя') ?>
        <?= $form->field($model, 'secondname')->textInput()->label('Отчество') ?>
        <?= $form->field($model, 'phone')->textInput()->label('Телефон') ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>

