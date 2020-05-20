<?php

use yii\db\Migration;

/**
 * Class m200520_041416_add_shop_delivery_index_edit
 */
class m200520_041416_add_shop_delivery_index_edit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('{{%idx-shop_delivery_methods-amount_cart_min}}', '{{%shop_delivery_methods}}');
        $this->createIndex('{{%idx-shop_delivery_methods-amount_cart_min}}', '{{%shop_delivery_methods}}', ['amount_cart_min', 'name'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200520_041416_add_shop_delivery_index_edit cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200520_041416_add_shop_delivery_index_edit cannot be reverted.\n";

        return false;
    }
    */
}
