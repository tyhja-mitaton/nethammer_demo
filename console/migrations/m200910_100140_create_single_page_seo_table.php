<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%single_page_seo}}`.
 */
class m200910_100140_create_single_page_seo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%single_page_seo}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%single_page_seo}}');
    }
}
