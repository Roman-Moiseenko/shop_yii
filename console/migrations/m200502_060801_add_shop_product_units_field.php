<?php

use yii\db\Migration;

/**
 * Class m200502_060801_add_shop_product_units_field
 */
class m200502_060801_add_shop_product_units_field extends Migration
{



    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%shop_products}}', 'units', $this->string('5')->defaultValue('шт'));
        $this->update('{{%shop_products}}', ['units' => 'шт']);
    }

    public function down()
    {
        $this->dropColumn('{{%shop_products}}', 'units');
    }

}
