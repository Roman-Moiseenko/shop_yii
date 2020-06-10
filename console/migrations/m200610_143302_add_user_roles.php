<?php

use yii\db\Migration;

/**
 * Class m200610_143302_add_user_roles
 */
class m200610_143302_add_user_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%auth_items}}', ['type', 'name', 'description'], [
            [1, 'user', 'Покупатель'],
            [1, 'admin', 'Администратор'],
            [1, 'superadmin', 'Супер Админ'],
            [1, 'manager', 'Менеджер сайта'],
            [1, 'trader', 'Продавец (менеджер заказов)'],
        ]);

        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            ['superadmin', 'admin'],
            ['admin', 'manager'],
            ['manager', 'trader'],
            ['trader', 'user'],
        ]);
        $this->execute('INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT \'user\', u.id FROM {{%users}} u ORDER BY u.id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200610_143302_add_user_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200610_143302_add_user_roles cannot be reverted.\n";

        return false;
    }
    */
}
