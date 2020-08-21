<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%info_block}}`.
 */
class m200821_102332_add_salary_column_to_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%info_block}}', 'salary', $this->integer()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%info_block}}', 'salary');
    }
}
