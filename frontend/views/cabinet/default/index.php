<?php

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\user\UserEditForm */

/* @var $user \shop\entities\user\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">
    <div class="panel panel-default">
        <div class="panel-heading"><h3><?= Html::encode($this->title) ?></h3></div>
        <div class="panel-body">
            <legend>Основные сведения&#160;<?= Html::a('Изменить', ['cabinet/profile/edit?id='.$user->id], ['class' => 'btn btn-default btn-xs']) ?></legend>
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Логин:</td>
                    <td class="userinfo">&#160;<?= $user->username ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Эл.почта:</td>
                    <td class="userinfo">&#160;<?= $user->email ?></td>
                </tr>
            </table>
            <p></p><br>
            <legend>Контактные данные&#160;<?= Html::a('Изменить', ['cabinet/profile/contact?id='.$user->id], ['class' => 'btn btn-default btn-xs']) ?></legend>
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Фамилия:</td>
                    <td class="userinfo">&#160;<?= $user->fullname->surname ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Имя:</td>
                    <td class="userinfo">&#160;<?= $user->fullname->firstname ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Отчество:</td>
                    <td class="userinfo">&#160;<?= $user->fullname->secondname ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Телефон:</td>
                    <td class="userinfo">&#160;<?= $user->phone ?></td>
                </tr>
            </table>
            <p></p><br>
            <legend>Адрес (для доставки)&#160;<?= Html::a('Изменить', ['cabinet/profile/delivery?id='.$user->id], ['class' => 'btn btn-default btn-xs']) ?></legend>
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Нас.пункт:</td>
                    <td class="userinfo">&#160;<?= $user->deliveryData->town ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Адрес:</td>
                    <td class="userinfo">&#160;<?= $user->deliveryData->address ?></td>
                </tr>
            </table>
        </div>
    </div>
    <h2>Привязать профиль из соц.сетей</h2>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>
