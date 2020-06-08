<?php

use yii\db\Migration;

/**
 * Class m200608_150138_add_shop_params_new_params_key
 */
class m200608_150138_add_shop_params_new_params_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%shop_params}}' ,[
            'key' => 'phoneOrder',
            'value' => '',
            'description' => 'Телефон, на который будут приходить СМС по новым и измененными заказам'
        ]);
        $this->insert('{{%shop_params}}' ,[
            'key' => 'sendEmail',
            'value' => '',
            'description' => 'Отправлять - 1 или нет - 0 уведомления по заказам на почту'
        ]);
        $this->insert('{{%shop_params}}' ,[
            'key' => 'sendPhone',
            'value' => '',
            'description' => 'Отправлять - 1 или нет - 0 уведомления по заказам СМС'
        ]);
        $this->insert('{{%shop_params}}' ,[
            'key' => 'sendTelegram',
            'value' => '',
            'description' => 'Отправлять - 1 или нет - 0 уведомления по заказам на Телеграм'
        ]);
        $this->insert('{{%shop_params}}' ,[
            'key' => 'timeClearOrder',
            'value' => '',
            'description' => 'Через сколько дней удалять неоплаченные заказы'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200608_150138_add_shop_params_new_params_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_150138_add_shop_params_new_params_key cannot be reverted.\n";

        return false;
    }
    */
}
