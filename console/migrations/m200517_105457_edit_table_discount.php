<?php

use yii\db\Migration;

/**
 * Class m200517_105457_edit_table_discount
 */
class m200517_105457_edit_table_discount extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%shop_discounts}}', 'from_date');
        $this->dropColumn('{{%shop_discounts}}', 'to_date');
        $this->addColumn('{{%shop_discounts}}', '_from', $this->string());
        $this->addColumn('{{%shop_discounts}}', '_to', $this->string());
        $this->addColumn('{{%shop_discounts}}', '_type', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_discounts}}', '_to');
        $this->dropColumn('{{%shop_discounts}}', '_from');
        $this->dropColumn('{{%shop_discounts}}', '_type');
        $this->addColumn('{{%shop_discounts}}', 'from_date', $this->date());
        $this->addColumn('{{%shop_discounts}}', 'to_date', $this->date());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200517_105457_edit_table_discount cannot be reverted.\n";

        return false;
    }
    */
}
