<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contact_data}}`.
 */
class m200902_105506_add_map_link_column_to_contact_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contact_data}}', 'map_link', $this->string()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contact_data}}', 'map_link');
    }
}
