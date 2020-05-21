<?php

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\user\UserEditForm*/
/* @var $user \shop\entities\user\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-heading">Основные сведения</div>
        <div class="panel-body">
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Логин: </td>
                    <td class="userinfo">&#160;<?= $user->username ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Эл.почта: </td>
                    <td class="userinfo">&#160;<?= $user->email ?></td>
                </tr>
            </table>

        </div>

            <p class="">
                <?= Html::a('Редактировать', ['cabinet/profile/editprofile'], ['class' => 'btn btn-default']) ?>
            </p>

    </div>
    <div class="row">
        <div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">Контактные данные</div>
        <div class="panel-body">
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Фамилия: </td>
                    <td class="userinfo">&#160;<?= $user->fullname->surname ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Имя: </td>
                    <td class="userinfo">&#160;<?= $user->fullname->firstname ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Отчество: </td>
                    <td class="userinfo">&#160;<?= $user->fullname->secondname ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Телефон: </td>
                    <td class="userinfo">&#160;<?= $user->phone ?></td>
                </tr>
            </table>
        </div>
        <p>
            <?= Html::a('Редактировать', ['cabinet/profile/editcontact'], ['class' => 'btn btn-default']) ?>
        </p>
    </div>
        </div>
        <div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">Адрес</div>
        <div class="panel-body">
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Нас.пункт: </td>
                    <td class="userinfo">&#160;<?= $user->deliveryData->town ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Адрес: </td>
                    <td class="userinfo">&#160;<?= $user->deliveryData->address ?></td>
                </tr>
            </table>
        </div>
        <p>
            <?= Html::a('Редактировать', ['cabinet/profile/editdelivery'], ['class' => 'btn btn-default']) ?>
        </p>
    </div>
        </div>
    </div>

    <h2>Attach profile</h2>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>
