<?php

use yii\db\Migration;

/**
 * Class m200525_000245_edit_shop_order_cost_field
 */
class m200525_000245_edit_shop_order_cost_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%shop_orders}}', 'cost', $this->float()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%shop_orders}}', 'cost', $this->integer()->notNull());
    }
}
