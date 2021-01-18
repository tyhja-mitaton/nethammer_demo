<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contact_data}}`.
 */
class m210118_085808_add_tg_link_column_to_contact_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contact_data}}', 'tg_link', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contact_data}}', 'tg_link');
    }
}
