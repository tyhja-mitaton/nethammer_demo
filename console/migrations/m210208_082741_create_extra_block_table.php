<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%extra_block}}`.
 */
class m210208_082741_create_extra_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%extra_block}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'btn_name' => $this->string()->null()->defaultValue(null),
            'btn_link' => $this->string()->null()->defaultValue(null),
            'img' => $this->string()->null()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%extra_block}}');
    }
}
