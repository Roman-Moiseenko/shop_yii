<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_hidden}}`.
 */
class m200508_103858_create_shop_hidden_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function Up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shop_hidden}}', [
            'id' => $this->primaryKey(),
            'code1C' => $this->string(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_hidden-code}}', '{{%shop_hidden}}', 'code1C', true);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('{{%shop_hidden}}');
    }
}
