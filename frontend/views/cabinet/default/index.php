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


    <div class="panel panel-default">
        <div class="panel-heading"><h2><?= Html::encode($this->title) ?></h2></div>
        <div class="panel-body">
            <legend><b>Основные сведения</b></legend>
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Логин: </td>
                    <td class="userinfo">&#160;<?= $user->username ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Эл.почта: </td>
                    <td class="userinfo">&#160;<?= $user->email ?></td>
                </tr>
                <tr>
                    <td class="userinfo">
                        <?= Html::a('Редактировать', ['cabinet/profile/editprofile'], ['class' => 'btn btn-default small']) ?>
                    </td>
                </tr>
            </table>

            <p></p><br>
            <legend><b>Контактные данные</b></legend>
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
                <tr>
                    <td class="userinfo">
                        <?= Html::a('Редактировать', ['cabinet/profile/editcontact'], ['class' => 'btn btn-default small']) ?>
                    </td>
                </tr>
            </table>
            <p></p><br>
            <legend><b>Адрес (для доставки)</b></legend>
            <table width="100%">
                <tr>
                    <td align="right" width="15%" class="userinfo">Нас.пункт: </td>
                    <td class="userinfo">&#160;<?= $user->deliveryData->town ?></td>
                </tr>
                <tr>
                    <td align="right" class="userinfo">Адрес: </td>
                    <td class="userinfo">&#160;<?= $user->deliveryData->address ?></td>
                </tr>
                <tr>
                    <td class="userinfo">
                        <?= Html::a('Редактировать', ['cabinet/profile/editdelivery'], ['class' => 'btn btn-default small']) ?>
                    </td>
                </tr>
            </table>
        </div>



    </div>


    <h2>Attach profile</h2>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>
