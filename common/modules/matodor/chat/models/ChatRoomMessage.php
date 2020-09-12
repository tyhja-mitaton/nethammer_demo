<?php

namespace matodor\chat\models;

use Yii;
use matodor\chat\models\ChatRoomUser;
use matodor\chat\models\ChatRoom;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Сущность - сообщение в чат-беседе
 *
 * @property integer $id Message id
 * @property integer $room_id
 * @property integer $chat_user_id
 * @property integer $create_time
 * @property integer $update_time
 * @property string $plain_text
 *
 * @property ChatRoom $chatRoom
 * @property ChatUser $sender
 * @property ChatRoomUser $roomUser
 * @property ChatAttachment[] $attachments
 */
class ChatRoomMessage extends ActiveRecord
{
    public function behaviors()
    {
        return
        [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'plain_text', 'chat_user_id'], 'required'],
            [['room_id', 'chat_user_id', 'create_time', 'update_time'], 'integer'],
            [['plain_text'], 'string', 'max' => 1024],
            [['room_id'], 'exist', 'targetClass' => ChatRoom::class, 'targetAttribute' => 'id'],
            [['chat_user_id'], 'exist', 'targetClass' => ChatUser::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * Возвращает запрос для прикрепленных файлов к сообщения
     * @return yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this
            ->hasMany(ChatAttachment::class, ['id' => 'attachment_id'])
            ->viaTable('chat_attachment_to_message', ['message_id' => 'id']);
    }

    /**
     * Возвращает запрос для выборки отправителя сообщения
     * @return yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(ChatUser::class, ['id' => 'chat_user_id']);
    }

    /**
     * Возвращает запрос для выборки чат-польователя комнаты
     * @return yii\db\ActiveQuery
     */
    public function getRoomUser()
    {
        return $this->hasOne(ChatRoomUser::class, [
            'chat_user_id' => 'chat_user_id',
            'room_id' => 'room_id'
        ]);
    }

    /**
     * Возвращает запрос для выборки чат-беседы, к которой относится сообщение
     * @return yii\db\ActiveQuery
     */
    public function getChatRoom()
    {
        return $this->hasOne(ChatRoom::class, ['id' => 'room_id']);
    }

    public static function tableName()
    {
        return '{{%chat_room_message}}';
    }
}

?>