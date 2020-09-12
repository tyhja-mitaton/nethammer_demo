<?php

namespace matodor\chat\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * @property integer $id
 * @property string $display_name
 * @property string $extension
 * @property string $token
 * @property integer $size
 * @property integer $chat_user_id
 *
 * @property ChatUser $chatUser
 */
class ChatAttachment extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $file;

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

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 1, 'maxSize' => 10485760], // 10mb

            [['display_name'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 10],
            [['token'], 'string', 'length' => 32],
            [['chat_user_id', 'size'], 'integer'],
            [['chat_user_id'], 'exist', 'targetClass' => ChatUser::class, 'targetAttribute' => 'id'],
        ];
    }

    public static function tableName()
    {
        return '{{%chat_attachment}}';
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getChatUser()
    {
        return $this->hasOne(ChatUser::class, ['id' => 'chat_user_id']);
    }

    public function upload()
    {
        if (!$this->validate(['file']))
            return false;

        $this->display_name = $this->file->name;
        $this->extension = $this->file->extension;
        $this->token = Yii::$app->getSecurity()->generateRandomString();
        $this->size = $this->file->size;

        if ($this->validate())
        {
            $path = $this->getPath();
            FileHelper::createDirectory(dirname($path));

            if ($this->file->saveAs($path))
            {
                if ($this->save(false))
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function getPath()
    {
        return $this->getDirectory() . '/' . $this->token;
    }

    public function getDirectory()
    {
        $path = Yii::$app->getModule('chat')->uploadedFilesPath;
        $path = Yii::getAlias($path . '/u' . $this->chat_user_id);
        return $path;
    }
}

?>