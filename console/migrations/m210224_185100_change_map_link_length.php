<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%confid_pol}}`.
 */
class m210224_185100_change_map_link_length extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%contact_data}}', 'map_link', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        throw new \yii\db\Exception('Can\'t rollback migration');
    }
}
