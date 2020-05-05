<?php

use yii\db\Migration;

/**
 * Class m200505_031547_add_shop_reviews_product_id_field
 */
class m200505_031547_add_shop_reviews_product_id_field extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%shop_reviews}}', 'product_id', $this->integer()->notNull());

        $this->createIndex('{{%idx-shop_reviews-product_id}}', '{{%shop_reviews}}', 'product_id');

        $this->addForeignKey('{{%fk-shop_reviews-product_id}}', '{{%shop_reviews}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropColumn('{{%shop_reviews}}', 'product_id');
    }

}
