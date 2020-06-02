<?php

use yii\db\Migration;

/**
 * Class m200602_144929_add_shop_params_new_params_key
 */
class m200602_144929_add_shop_params_new_params_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%shop_params}}' ,[
            'key' => 'emailOrder',
            'value' => '',
            'description' => 'Email, на который будут приходить по новым и измененными заказам'
        ]);
        $this->insert('{{%shop_params}}' ,[
            'key' => 'phoneMain',
            'value' => '',
            'description' => 'Основной телефон для звонков клиентов (верхнее меню сайта)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200602_144929_add_shop_params_new_params_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200602_144929_add_shop_params_new_params_key cannot be reverted.\n";

        return false;
    }
    */
}
