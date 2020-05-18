<?php

use yii\db\Migration;

/**
 * Class m200518_034241_drop_discounts_table_sort_field
 */
class m200518_034241_drop_discounts_table_sort_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%shop_discounts}}', 'sort');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%shop_discounts}}', 'sort', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200518_034241_drop_discounts_table_sort_field cannot be reverted.\n";

        return false;
    }
    */
}
