<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "appeal".
 *
 * @property int $id
 * @property string $author
 * @property string $phone
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Appeal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appeal';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author'], 'required', 'message' => 'Необходимо заполнить поле "Имя"'],
            [['phone'], 'required', 'message' => 'Необходимо заполнить поле "Телефон"'],
            [['email'], 'required', 'message' => 'Необходимо заполнить поле "E-mail"'],
            [['author', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Автор',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    public function sendEmail($email, $contactData, $appeal)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom($appeal->email)
            ->setSubject($contactData->subject)
            ->setTextBody($appeal->author.' '.$appeal->phone)
            ->send();
    }
}
