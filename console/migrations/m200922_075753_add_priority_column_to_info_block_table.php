<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%info_block}}`.
 */
class m200922_075753_add_priority_column_to_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%info_block}}', 'priority', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%info_block}}', 'priority');
    }
}
