<?php

namespace matodor\chat\models;

use Yii;
use yii\db\ActiveRecord;
use matodor\chat\models\ChatRoom;

/**
 * Сущность - пользователь чат-беседы
 *
 * @property integer $id
 * @property integer $room_id Идентификатор беседы
 * @property integer $chat_user_id Идентификатор чат-пользователя
 * @property integer $rights Права чат-пользователя в беседе
 * @property bool $has_unread Имеются ли непрочитанные сообщения
 *
 * @property ChatRoom $chatRoom
 * @property ChatUser $chatUser
 */
class ChatRoomUser extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'chat_user_id'], 'required'],
            [['room_id', 'chat_user_id', 'rights'], 'integer'],
            [['has_unread'], 'boolean'],
            [['chat_user_id'], 'exist', 'targetClass' => ChatUser::class, 'targetAttribute' => 'id'],
            [['room_id'], 'exist', 'targetClass' => ChatRoom::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * Возвращает запрос для выборки чат-беседы, к которой относится пользователь беседы
     *
     * @return yii\db\ActiveQuery
     */
    public function getChatRoom()
    {
        return $this->hasOne(ChatRoom::class, ['id' => 'room_id']);
    }

    /**
     * Возвращает запрос для выборки чат-пользователя
     *
     * @return yii\db\ActiveQuery
     */
    public function getChatUser()
    {
        return $this->hasOne(ChatUser::class, ['id' => 'chat_user_id']);
    }

    public static function tableName()
    {
        return '{{%chat_room_user}}';
    }
}

?>