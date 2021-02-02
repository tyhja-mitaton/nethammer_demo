<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%info_block}}`.
 */
class m210202_092400_add_intro_column_to_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%info_block}}', 'intro', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%info_block}}', 'intro');
    }
}
