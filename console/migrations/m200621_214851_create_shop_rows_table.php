<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_loaddata_rows}}`.
 */
class m200621_214851_create_shop_rows_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop_rows}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'type_data' => $this->integer(),
            'load_row' => 'JSON NOT NULL'
        ]);
        //$this->addPrimaryKey('{{%pk-shop_loaddata_rows}}', '{{%shop_loaddata_rows}}', ['id']);

        $this->createIndex('{{%idx-shop_rows-parent_id}}', '{{%shop_rows}}', ['parent_id']);
        $this->addForeignKey('{{%fk-shop_rows-parent_id}}', '{{%shop_rows}}', 'parent_id', '{{%shop_files}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_rows}}');
    }
}
