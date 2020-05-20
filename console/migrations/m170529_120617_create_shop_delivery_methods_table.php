<?php

use yii\db\Migration;

class m170529_120617_create_shop_delivery_methods_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_delivery_methods}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'cost' => $this->integer()->notNull(),
            'amount_cart_min' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_delivery_methods-amount_cart_min}}', '{{%shop_delivery_methods}}', ['amount_cart_min', 'name'], true);
    }

    public function down()
    {
        $this->dropTable('{{%shop_delivery_methods}}');
    }
}
