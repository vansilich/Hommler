<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m211121_161655_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'sku'   => $this->string()->unique()->notNull()->check("sku <> ''"),
            'image' => $this->string(),
            'title' => $this->string()->notNull(),
            'qty'   => $this->integer()->notNull(),
            'type'  => $this->string(),
            'PRIMARY KEY (sku)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
