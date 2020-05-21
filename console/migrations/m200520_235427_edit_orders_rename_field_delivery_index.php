<?php

use yii\db\Migration;

/**
 * Class m200520_235427_edit_orders_rename_field_delivery_index
 */
class m200520_235427_edit_orders_rename_field_delivery_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%shop_orders}}', 'delivery_index', 'delivery_town');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%shop_orders}}', 'delivery_town', 'delivery_index');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200520_235427_edit_orders_rename_field_delivery_index cannot be reverted.\n";

        return false;
    }
    */
}
