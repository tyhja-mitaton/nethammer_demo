<?php

namespace matodor\chat\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Сущность - контактная информация чат-пользователя
 *
 * @property integer $chat_user_id Идентификатор чат-пользователя
 * @property string $email Email пользователя
 * @property string $name Отображаемое имя
 *
 * @property ChatUser $chatUser Чат-пользователь
 */
class ChatUserProfile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_user_id', 'email', 'name'], 'required'],
            [['chat_user_id'], 'integer'],
            [['email', 'name'], 'string', 'max' => 256],
            [['email'], 'email'],
            [['chat_user_id'], 'exist', 'targetClass' => ChatUser::class, 'targetAttribute' => 'id'],
        ];
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
        return '{{%chat_user_profile}}';
    }
}

?>