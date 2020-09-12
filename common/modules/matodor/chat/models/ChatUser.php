<?php

namespace matodor\chat\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;
use \dektrium\user\models\User as DektriumUser;

/**
 * Сущность - чат-пользователь
 *
 * @property integer $id Идентификатор чат-пользователя
 * @property integer|null $user_id Идентификатор пользователя Yii2
 * @property string $token Токен доступа
 *
 * @property ChatUserProfile $profile
 */
class ChatUser extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chat_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token'], 'required'],
            [['token'], 'string', 'length' => 32],
            [['user_id'], 'exist', 'skipOnEmpty' => true, 'targetClass' => DektriumUser::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert)
        {
            if (!empty($this->user_id))
            {
                $user = DektriumUser::findOne(['id' => $this->user_id]);
                $profile = new ChatUserProfile();
                $profile->chat_user_id = $this->id;
                $profile->email = $user->email;
                $profile->name = $user->username;
                $profile->save();
            }
        }
    }

    /**
     * Возвращает запрос для выборки профиля чат-пользователя
     *
     * @return yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(ChatUserProfile::class, ['chat_user_id' => 'id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getRoomsUser()
    {
        return $this->hasMany(ChatRoomUser::class, ['chat_user_id' => 'id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(ChatRoomMessage::class, ['chat_user_id' => 'id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getRooms()
    {
        $subQuery = $this->getRoomsUser()
            ->select([
                'chat_room_user.room_id',
                'chat_room_user.rights',
                'chat_room_user.has_unread']);

        return ChatRoom::find()
            ->select([
                'chat_room.*',
                'u.rights',
                'u.has_unread'])
            ->innerJoin(['u' => $subQuery], 'u.room_id = chat_room.id');
    }

    /**
     * @param yii\db\ActiveQuery $query
     * @return array
     */
    public function getRoomsWithData($query)
    {
        $rooms = $query->asArray()->all();

        foreach ($rooms as &$room)
            self::setRoomData($room);

        return $rooms;
    }

    /**
     * Массив данных модели чат-комнаты
     *
     * @param array $roomData Указатель на массив с данными
     * @return void
     */
    public static function setRoomData(&$roomData)
    {
        $model = new ChatRoom();
        $model->setAttributes($roomData, false);
        $messages = $model->getHistory(null, 1, false);

        $profilesQuery = ChatUserProfile::find();
        $users = $model->getUsers()
            ->select([
                'chat_room_user.*',
                'p.email',
                'p.name'])
            ->innerJoin(['p' => $profilesQuery], 'p.chat_user_id = chat_room_user.chat_user_id')
            ->asArray()
            ->all();

        foreach ($users as $user)
            $roomData['users'][$user['chat_user_id']] = $user;

        $roomData['lastMessage'] = count($messages) > 0
            ? $messages[0]
            : null;
    }

    public function getUnreadCount($condition = null)
    {
        return ChatRoomUser::find()
            ->select(['chat_room_user.*'])
            ->leftJoin('chat_room', 'chat_room.id = chat_room_user.room_id')
            ->andWhere(['chat_room_user.chat_user_id' => $this->id])
            ->andWhere(['chat_room_user.has_unread' => true])
            ->andFilterWhere($condition)
            ->count();
    }
}

?>