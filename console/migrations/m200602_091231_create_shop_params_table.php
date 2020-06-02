<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_params}}`.
 */
class m200602_091231_create_shop_params_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop_params}}', [
            'key' => $this->string()->notNull(),
            'value' => $this->string()
        ]);
        $this->addPrimaryKey('{{%pk-shop_params}}', '{{%shop_params}}', ['key']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_params}}');
    }
}
