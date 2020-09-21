<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%info_block}}`.
 */
class m200921_103311_add_tag_column_to_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%info_block}}', 'tag', $this->integer()->notNull()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%info_block}}', 'tag');
    }
}
