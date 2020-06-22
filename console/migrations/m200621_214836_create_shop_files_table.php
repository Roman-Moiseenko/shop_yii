<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_loaddata}}`.
 */
class m200621_214836_create_shop_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop_files}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(),
            'type_data' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'count_rows' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_files}}');
    }
}
