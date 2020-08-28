<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_data}}`.
 */
class m200828_110524_create_contact_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_data}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string()->null()->defaultValue(null),
            'emails' => $this->string()->notNull()->defaultValue('admin@example.com'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact_data}}');
    }
}
