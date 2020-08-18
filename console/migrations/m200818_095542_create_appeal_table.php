<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appeal}}`.
 */
class m200818_095542_create_appeal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%appeal}}', [
            'id' => $this->primaryKey(),
            'author' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%appeal}}');
    }
}
