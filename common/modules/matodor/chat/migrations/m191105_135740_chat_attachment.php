<?php

use yii\db\Migration;

/**
 * Class m191105_135740_chat_attachment
 */
class m191105_135740_chat_attachment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat_attachment}}', [
            'id' => $this->primaryKey()->unsigned(),
            'display_name' => $this->string()->notNull(),
            'extension' => $this->string(10)->notNull(),
            'token' => $this->string(32)->notNull(),
            'size' => $this->integer()->unsigned()->notNull(),
            'chat_user_id' => $this->integer()->unsigned()->notNull(),
            'create_time' => $this->integer(11)->notNull(),
            'update_time' => $this->integer(11)->notNull(),
        ]);

        $this->createTable('{{%chat_attachment_to_message}}', [
            'message_id' => $this->integer()->unsigned()->notNull(),
            'attachment_id' => $this->integer()->unsigned()->notNull()
        ]);

        $this->createIndex('dx_chat_attachment-token',        '{{%chat_attachment}}', 'token', false);
        $this->createIndex('dx_chat_attachment-chat_user_id', '{{%chat_attachment}}', 'chat_user_id', false);
        $this->addForeignKey('fk_chat_attachment-chat_user_id', '{{%chat_attachment}}', 'chat_user_id', '{{%chat_user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('dx_chat_attachment_to_message-message_id',    '{{%chat_attachment_to_message}}', 'message_id', false);
        $this->createIndex('dx_chat_attachment_to_message-attachment_id', '{{%chat_attachment_to_message}}', 'attachment_id', false);
        $this->addForeignKey('fk_chat_attachment_to_message-message_id', '{{%chat_attachment_to_message}}', 'message_id', '{{%chat_room_message}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_chat_attachment_to_message-attachment_id', '{{%chat_attachment_to_message}}', 'attachment_id', '{{%chat_attachment}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0")->execute();

        $this->dropTable('{{%chat_attachment_to_message}}');
        $this->dropTable('{{%chat_attachment}}');

        \Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1")->execute();
    }
}
