<?php

namespace matodor\chat\models;

use Yii;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * @property integer $message_id
 * @property integer $attachment_id
 *
 * @property ChatRoomMessage $message
 * @property ChatAttachment $attachment
 */
class ChatAttachmentToMessage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'attachment_id'], 'required'],
            [['message_id', 'attachment_id'], 'integer'],
            [['message_id'], 'exist', 'targetClass' => ChatRoomMessage::class, 'targetAttribute' => 'id'],
            [['attachment_id'], 'exist', 'targetClass' => ChatAttachment::class, 'targetAttribute' => 'id'],
        ];
    }

    public static function tableName()
    {
        return '{{%chat_attachment_to_message}}';
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(ChatRoomMessage::class, ['id' => 'message_id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getAttachment()
    {
        return $this->hasOne(ChatAttachment::class, ['id' => 'attachment_id']);
    }
}

?>