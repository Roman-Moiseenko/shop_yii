<?php


namespace shop\helpers;


use shop\entities\user\WishlistItem;

class WishlistHelper
{
    public static function count()
    {
        if (\Yii::$app->user->isGuest) return 0;
        return WishlistItem::find()->andWhere(['user_id' => \Yii::$app->user->id])->orderBy('user_id')->count();
    }
}