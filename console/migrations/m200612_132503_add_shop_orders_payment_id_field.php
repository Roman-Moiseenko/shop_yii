<?php

use yii\db\Migration;

/**
 * Class m200612_132503_add_shop_orders_payment_id_field
 */
class m200612_132503_add_shop_orders_payment_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_orders}}', 'payment_id', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_orders}}', 'payment_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200612_132503_add_shop_orders_payment_id_field cannot be reverted.\n";

        return false;
    }
    */
}
