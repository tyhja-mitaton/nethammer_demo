<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%info_block}}`.
 */
class m210217_100537_add_extra_descr_column_to_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%info_block}}', 'extra_descr', $this->text()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%info_block}}', 'extra_descr');
    }
}
