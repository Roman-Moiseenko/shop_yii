<?php

use yii\db\Migration;

/**
 * Class m200521_064040_add_users_fields
 */
class m200521_064040_add_users_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%users}}', 'phone', $this->string(25));
        $this->addColumn('{{%users}}', 'delivery_town', $this->string(255));
        $this->addColumn('{{%users}}', 'delivery_address', $this->string(255));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'phone');
        $this->dropColumn('{{%users}}', 'delivery_town');
        $this->dropColumn('{{%users}}', 'delivery_address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200521_064040_add_users_fields cannot be reverted.\n";

        return false;
    }
    */
}
