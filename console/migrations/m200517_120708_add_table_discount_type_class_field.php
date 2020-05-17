<?php

use yii\db\Migration;

/**
 * Class m200517_120708_add_table_discount_type_class_field
 */
class m200517_120708_add_table_discount_type_class_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_discounts}}', 'type_class', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_discounts}}', 'type_class');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200517_120708_add_table_discount_type_class_field cannot be reverted.\n";

        return false;
    }
    */
}
