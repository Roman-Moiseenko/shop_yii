<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_reg}}`.
 */
class m200511_001121_create_shop_reg_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_reg}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'reg_match' => $this->string()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_reg-category_id}}', '{{%shop_reg}}', 'category_id');
        $this->createIndex('{{%idx-shop_reg-characteristic_id}}', '{{%shop_reg}}', 'characteristic_id');

        $this->addForeignKey('{{%fk-shop_reg-category_id}}', '{{%shop_reg}}', 'category_id', '{{%shop_categories}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shop_reg-characteristic_id}}', '{{%shop_reg}}', 'characteristic_id', '{{%shop_characteristics}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable('{{%shop_reg}}');
    }

}
