<?php

use yii\db\Migration;

/**
 * Class m200602_123603_add_shop_params_discription_field
 */
class m200602_123603_add_shop_params_description_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_params}}', 'description', $this->string(255));
        $this->alterColumn('{{%shop_params}}', 'key', $this->string(30));
        $this->alterColumn('{{%shop_params}}', 'value', $this->string(128));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_params}}', 'description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200602_123603_add_shop_params_discription_field cannot be reverted.\n";

        return false;
    }
    */
}
