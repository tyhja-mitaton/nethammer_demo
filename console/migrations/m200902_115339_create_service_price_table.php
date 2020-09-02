<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_price}}`.
 */
class m200902_115339_create_service_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_price}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->null()->defaultValue(null),
            'text' => $this->string()->null()->defaultValue(null),
            'service_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk-service_price-service_id',
            '{{%service_price}}',
            'service_id',
            'info_block',
            'id',
            'CASCADE');
        $this->createIndex(
            'idx-service_price-service_id',
            '{{%service_price}}',
            'service_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-service_price-service_id',
            '{{%service_price}}'
        );
        $this->dropIndex(
            'idx-service_price-service_id',
            '{{%service_price}}'
        );
        $this->dropTable('{{%service_price}}');
    }
}
