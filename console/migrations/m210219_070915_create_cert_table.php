<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cert}}`.
 */
class m210219_070915_create_cert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cert}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string()->null()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cert}}');
    }
}
