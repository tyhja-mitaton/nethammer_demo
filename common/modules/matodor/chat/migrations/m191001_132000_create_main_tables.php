<?php

use dektrium\user\models\User as DektriumUser;
use matodor\chat\models\ChatUser;
use yii\db\Migration;

class m191001_132000_create_main_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat_room}}', [
            'id' => $this->primaryKey()->unsigned(),
            'group' => $this->string(256)->null()->defaultValue(null),
            'token' => $this->string(32)->unique()->notNull(),
            'title' => $this->string(256),
            'create_time' => $this->integer(11)->notNull(),
            'update_time' => $this->integer(11)->notNull(),
        ]);

        $this->createTable('{{%chat_room_message}}', [
            'id' => $this->primaryKey()->unsigned(),
            'room_id' => $this->integer()->unsigned()->notNull(),
            'chat_user_id' => $this->integer()->unsigned()->notNull(),
            'create_time' => $this->integer(11)->notNull(),
            'update_time' => $this->integer(11)->notNull(),
            'plain_text' => $this->text()->notNull()
        ]);

        $this->createTable('{{%chat_room_user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'room_id' => $this->integer()->unsigned()->notNull(),
            'chat_user_id' => $this->integer()->unsigned()->notNull(),
            'rights' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'has_unread' => $this->boolean()->defaultValue(false),
        ]);

        $this->createTable('{{%chat_user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->null()->defaultValue(null),
            'token' => $this->string(32)->unique()->notNull(),
        ]);

        $this->createTable('{{%chat_user_profile}}', [
            'chat_user_id' => $this->integer()->unsigned()->notNull(),
            'email' => $this->string(256)->notNull(),
            'name' => $this->string(256)->notNull(),
        ]);

        // chat_room
        $this->createIndex('dx_chat_room-group', '{{%chat_room}}', 'group', false);
        $this->createIndex('dx_chat_room-token', '{{%chat_room}}', 'token', true);

        // chat_room_message
        $this->createIndex('dx_chat_room_message-room_id', '{{%chat_room_message}}', 'room_id', false);
        $this->createIndex('dx_chat_room_message-chat_user_id', '{{%chat_room_message}}', 'chat_user_id', false);
        $this->addForeignKey('fk_chat_room_message-room_id', '{{%chat_room_message}}', 'room_id', '{{%chat_room}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-chat_room_message-chat_user_id', '{{%chat_room_message}}', 'chat_user_id', '{{%chat_user}}', 'id', 'CASCADE', 'CASCADE');

        // chat_room_user
        $this->createIndex('dx_chat_room_user-room_id', '{{%chat_room_user}}', 'room_id', false);
        $this->createIndex('dx_chat_room_user-chat_user_id', '{{%chat_room_user}}', 'chat_user_id', false);
        $this->addForeignKey('fk_chat_room_user-room_id', '{{%chat_room_user}}', 'room_id', '{{%chat_room}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-chat_room_user-chat_user_id', '{{%chat_room_user}}', 'chat_user_id', '{{%chat_user}}', 'id', 'CASCADE', 'CASCADE');

        // chat_user
        $this->createIndex('dx_chat_user-token', '{{%chat_user}}', 'token', true);
        $this->createIndex('dx_chat_user-user_id', '{{%chat_user}}', 'user_id', true);
        $this->addForeignKey('fk-chat_user-user_id', '{{%chat_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        // chat_user_profile
        $this->addPrimaryKey('pk_chat_user_profile-chat_user_id', '{{%chat_user_profile}}', 'chat_user_id');
        $this->createIndex('dx_chat_user_profile-chat_user_id', '{{%chat_user_profile}}', 'chat_user_id', true);
        $this->addForeignKey('fk-chat_user_profile-chat_user_id', '{{%chat_user_profile}}', 'chat_user_id', '{{%chat_user}}', 'id', 'CASCADE', 'CASCADE');

        $query = DektriumUser::find();
        foreach ($query->each() as $user)
        {
            /** @var DektriumUser $user */
            $chatUser = new ChatUser();
            $chatUser->user_id = $user->id;
            $chatUser->token = \Yii::$app->security->generateRandomString();

            if (!$chatUser->save())
                throw new \yii\base\Exception('Can\'t create ChatUser');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0")->execute();

        $this->dropTable('{{%chat_room}}');
        $this->dropTable('{{%chat_room_message}}');
        $this->dropTable('{{%chat_room_user}}');
        $this->dropTable('{{%chat_user}}');

        \Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1")->execute();
    }
}
