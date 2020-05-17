<?php

use yii\db\Migration;

/**
 * Class m200517_122538_del_table_discount_type_field
 */
class m200517_122538_del_table_discount_type_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%shop_discounts}}', '_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%shop_discounts}}', '_type', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200517_122538_del_table_discount_type_field cannot be reverted.\n";

        return false;
    }
    */
}
