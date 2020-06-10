<?php

namespace backend\widgets\grid;

use shop\entities\user\Rbac;
use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\rbac\Item;

class RoleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $roles = Yii::$app->authManager->getRolesByUser($model->id);
        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function (Item $role) {
            return $this->getRoleLabel($role);
        }, $roles));
    }

    private function getRoleLabel(Item $role): string
    {
        switch ($role->name) {
            case Rbac::ROLE_USER: $class = 'default'; break;
            case Rbac::ROLE_TRADER: $class = 'primary'; break;
            case Rbac::ROLE_MANAGER: $class = 'warning'; break;
            case Rbac::ROLE_SUPERADMIN:
            case Rbac::ROLE_ADMIN: $class = 'danger'; break;
            default: $class = 'primary';

        }
       // $class = $role->name == Rbac::ROLE_USER ? 'primary' : 'danger';
        return Html::tag('span', Html::encode($role->description), ['class' => 'label label-' . $class]);
    }
}