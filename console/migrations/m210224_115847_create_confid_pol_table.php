<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%confid_pol}}`.
 */
class m210224_115847_create_confid_pol_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%confid_pol}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%confid_pol}}');
    }
}
