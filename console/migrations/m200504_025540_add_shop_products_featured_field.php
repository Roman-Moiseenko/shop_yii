<?php

use yii\db\Migration;

/**
 * Class m200504_025540_add_shop_products_featured_field
 */
class m200504_025540_add_shop_products_featured_field extends Migration
{
    public function up()
    {

        $this->addColumn('{{%shop_products}}', 'featured', $this->boolean()->defaultValue(false));
        $this->update('{{%shop_products}}', ['featured' => false]);
    }

    public function down()
    {
        $this->dropColumn('{{%shop_products}}', 'featured');


    }
}
