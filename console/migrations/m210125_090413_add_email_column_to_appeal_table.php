<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%appeal}}`.
 */
class m210125_090413_add_email_column_to_appeal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%appeal}}', 'email', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%appeal}}', 'email');
    }
}
