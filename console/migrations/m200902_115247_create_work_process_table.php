<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%work_process}}`.
 */
class m200902_115247_create_work_process_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%work_process}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->null()->defaultValue(null),
            'text' => $this->text()->null(),
            'block1_text' => $this->string()->notNull()->defaultValue('Быстро'),
            'block2_text' => $this->string()->notNull()->defaultValue('Качественно'),
            'service_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-work_process-service_id',
            '{{%work_process}}',
            'service_id',
            'info_block',
            'id',
            'CASCADE');
        $this->createIndex(
            'idx-work_process-service_id',
            '{{%work_process}}',
            'service_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-work_process-service_id',
            '{{%work_process}}'
        );
        $this->dropIndex(
            'idx-work_process-service_id',
            '{{%work_process}}'
        );
        $this->dropTable('{{%work_process}}');
    }
}
