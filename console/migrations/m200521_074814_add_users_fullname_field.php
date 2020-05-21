<?php

use yii\db\Migration;

/**
 * Class m200521_074814_add_users_fullname_field
 */
class m200521_074814_add_users_fullname_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'fullname_json', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'fullname_json');
    }

}
