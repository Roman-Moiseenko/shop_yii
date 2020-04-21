<?php


namespace shop\entities;


use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * @property integer $user_id
 * @property string $network
 * @property  string $identity
 */
class Network extends ActiveRecord
{

    public static function create($network, $identity): self
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);
        $item = new static();
        $item->network = $network;
        $item->identity = $network;
        return $item;
    }

    public static function tableName()
    {
        return '{{%user_networks}}';
    }
}