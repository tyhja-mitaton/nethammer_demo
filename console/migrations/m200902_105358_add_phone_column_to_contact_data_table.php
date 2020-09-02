<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contact_data}}`.
 */
class m200902_105358_add_phone_column_to_contact_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contact_data}}', 'phone', $this->string()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contact_data}}', 'phone');
    }
}
