<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%info_block}}`.
 */
class m200814_121052_create_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%info_block}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'btn_name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'imgs' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%info_block}}');
    }
}
