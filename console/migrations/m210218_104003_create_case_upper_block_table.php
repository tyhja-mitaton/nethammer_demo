<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%case_upper_block}}`.
 */
class m210218_104003_create_case_upper_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%case_upper_block}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->null()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%case_upper_block}}');
    }
}
