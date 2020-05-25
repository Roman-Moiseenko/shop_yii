<?php

use yii\db\Migration;

/**
 * Class m200524_234716_add_shop_order_cost_discount_fields
 */
class m200524_234716_add_shop_order_cost_discount_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_orders}}', 'cost_original', $this->float()->notNull());
        $this->addColumn('{{%shop_orders}}', 'discount', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_orders}}', 'cost_original');
        $this->dropColumn('{{%shop_orders}}', 'discount');
    }

}
