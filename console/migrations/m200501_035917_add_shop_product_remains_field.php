<?php

use yii\db\Migration;

/**
 * Class m200501_035917_add_shop_product_remains_field
 */
class m200501_035917_add_shop_product_remains_field extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        $this->addColumn('{{%shop_products}}', 'remains', $this->float()->defaultValue(0));
        $this->update('{{%shop_products}}', ['remains' => 0]);
    }

    public function down()
    {
        $this->dropColumn('{{%shop_products}}', 'remains');

        return false;
    }

}
